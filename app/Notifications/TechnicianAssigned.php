<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TechnicianAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $serviceOrderNumber;
    /**
     * Create a new notification instance.
     */
    public function __construct($serviceOrderNumber)
    {
        $this->serviceOrderNumber = $serviceOrderNumber;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Fuiste asignado a la orden número ' . $this->serviceOrderNumber . '.')
            ->salutation('Saludos,')
            ->subject('Se te ha asignado una nueva orden de servicio');
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
