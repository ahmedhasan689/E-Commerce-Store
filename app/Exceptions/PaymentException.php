<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentException extends Exception
{
    /**
     * @var \App\Models\Order;
     */
    protected $order;

    public function render(Request $request)
    {
        return redirect('admin/categories')->with('error', $this->getMessage());
        // return $this->getMessage();
    }

    public function report()
    {
        Log::error('Payment Failed !');
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }
}
