<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl;
use Symfony\Component\Intl\Languages;
use Illuminate\Support\Facades\App;
use App\Notifications\OrderCreatedNotification;
// use Symfony\Component\Intl\Locales;

use App\Models\Order;
use App\Models\User;

class CheckoutController extends Controller
{
    /**
     * @var \App\Repositories\Cart\CartRepository
     */
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function create()
    {
        return view('front.checkout', [
            'cart' => $this->cart,
            'user' => Auth::user(),
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'billing_name' => ['required', 'string'],
            'billing_phone' => 'required',
            'billing_email' => 'required|email',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $request->merge([
                'total' => $this->cart->total(),
            ]);
            $order = Order::create($request->all());

            $items = [];

            foreach($this->cart->all() as $item){
                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ];
            }
            DB::table('order_items')->insert($items);

            DB::commit();

            // $user = User::where('type', 'super-admin')->first();
            // $user->notify( new OrderCreatedNotification($order) );

            event(new OrderCreated($order));
            
            return redirect()->route('orders')->with('success', __('Order Created'));

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
