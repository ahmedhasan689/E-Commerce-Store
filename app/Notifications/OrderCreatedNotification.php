<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use Illuminate\Notifications\Messages\NexmoMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Mail, Database, Nexmo-(SMS) , Broadcast, Slack, Custom Channel

        $via = [
            'database',
            'mail',
            'broadcast',
            // 'nexmo',
            FcmChannel::class,
        ];

        /* if ($notifiable->notify_sms) {
            $via[] = 'nexmo';
        }
        if ($notifiable->notify_mail) {
            $via[] = 'mail';
        } */

        return $via;

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('New Order #:number', ['number' => $this->order->number]))
                    ->from('invoices@localhost', 'E-Commerce-Store')
                    ->greeting(__('Hello, :name', ['name' => $notifiable->name]))
                    ->line(__('A New Order Has Been Created (Order #:number).', ['number' => $notifiable->number] ))
                    ->action('View Order', url('/'))
                    ->line('Thank you for Shopping With Us !');

                    /* ->view('', [
                        'order' => $this->order,
                    ]); */
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => __('New Order #:number', ['number' => $this->order->number]),

            'body' => __('A New Order Has Been Created (Order #:number).', ['number' => $notifiable->number] ),

            'icon' => '',
            'url' => url('/'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage([
            'title' => __('New Order #:number', ['number' => $this->order->number]),

            'body' => __('A New Order Has Been Created (Order #:number).', ['number' => $notifiable->number] ),

            'icon' => '',
            'url' => url('/'),
        ]));
    }

    // public function toNexmo($notifiable)
    // {
    //     $message = new NexmoMessage();
    //     $message->content( 'A New Order Has Been Created (Order #:number).'  );

    //     return $message;
    // }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'order_id' => $this->order->id
            ])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Account Activated')
                ->setBody('Your account has been activated.')
                ->setImage('http://example.com/url-to-image-here.png'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
