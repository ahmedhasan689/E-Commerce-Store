<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderInvoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendInvoiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        $users = User::whereIn('type', ['super-admin', 'admin'])->get();
//        foreach ($users as $user) {
//            $user->notify( new OrderCreatedNotification($order) );
//        }
        Notification::send($users,  new OrderCreatedNotification($order) );
       /*  Notification::route('mail', 'hlhatab@gmail.com')->route('mail', 'admin@example.com')
        ->route('nexmo', '+970'); */

        // Mail::to($order->billing_email)->send(new OrderInvoice($order));
    }
}
