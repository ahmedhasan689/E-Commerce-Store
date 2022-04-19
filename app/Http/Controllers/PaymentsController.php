<?php

namespace App\Http\Controllers;

use App\Exceptions\PaymentException;
use Illuminate\Http\Request;
use PayPalHttp\HttpException;
use Illuminate\Support\Facades\App;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

use App\Models\Order;

class PaymentsController extends Controller
{
    /**
     * @var \PayPalCheckoutSdk\Core\PayPalHttpClient;
     */
    protected $client;

    public function __construct()
    {
        $this->client = App::make('paypal.client');
    }

    public function create(Order $order)
    {
        if ($order->payment_status == 'paid') {
            $e = new PaymentException('Order Already Paid!');
            $e->setOrder($order);

            throw $e;


            return redirect('orders')->with('status', 'Order Already Paid!');
        }

        $payment = $order->payments()->where('type', 'payment')->where('status', 'CREATED')->first();

        if($payment) {
            $links = collect($payment->data['result']['links']);
            $link = $links->where('rel', '=', 'approve')->first();
            return redirect()->away($link->href);
        }

        // Authorize
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $order->id,
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => "ILS",
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('order.payments.cancel', [$order->id])),
                "return_url" => url(route('order.payments.return', [$order->id])),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            if($response && $response->statusCode == 201) {
                $links = collect($response->result->links);

                $link = $links->where('rel', '=', 'approve')->first();

                $order->payments()->create([
                    'type' => 'payment',
                    'reference_id' => $response->result->id,
                    'amount' => $order->total,
                    'currency' => 'ILS',
                    'status' => $response->result->status,
                    'data' => $response,
                ]);

                return redirect()->away($link->href);

                // foreach ($links as $link) {
                //     if ($link->rel == 'approve') {
                //         return redirect()->away($link->href);
                //     }
                // }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            // dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function callback(Order $order)
    {
        if ($order->payment_status == 'paid') {
            return redirect('orders')->with('status', 'Order Already Paid!');
        }

        // Capture
        $paypal_order_id = request('token');

        $payment = $order->payments()->where('reference_id', $paypal_order_id)->first();

        $payment->status = 'APPROVED';
        $payment->save();

        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            if($response && $response->statusCode == 201) {
                $order->payment_status = 'paid';
                $order->save();

                $payment->status = $response->result->status;
                $payment->save();
            }
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}
