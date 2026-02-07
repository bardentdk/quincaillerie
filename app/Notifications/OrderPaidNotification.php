<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaidNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // app/Notifications/OrderPaidNotification.php
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📦 Nouvelle commande sur la Quincaillerie !')
            ->line('La commande #' . $this->order->order_number . ' vient d\'être payée.')
            ->line('Montant : ' . ($this->order->total_amount_cents / 100) . '€')
            ->action('Voir la commande', url('/admin/orders/' . $this->order->id))
            ->line('Préparez le colis pour l\'expédition.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
