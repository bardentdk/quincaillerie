<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Support\Facades\Mail;

class SendShippingNotification
{
    public function handle(OrderShipped $event)
    {
        // Alerte à la quincaillerie (Admin)
        Mail::to('admin@quincaillerie-arcs.com')->send(new \App\Mail\AdminOrderShipped($event->order));
        
        // Notification au client
        $event->order->user->notify(new \App\Notifications\YourOrderIsOnTheWay($event->order));
    }
}