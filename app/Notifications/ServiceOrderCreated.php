<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceOrderCreated extends Notification
{
    use Queueable;

    protected $requestor;
    protected $serviceOrderNumber;
    /**
     * Create a new notification instance.
     */
    public function __construct($requestor, $serviceOrderNumber)
    {
        $this->requestor = $requestor;
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
            ->line($this->requestor . ' ha abierto una nueva orden de servicio con el número ' . $this->serviceOrderNumber . '.')
            ->line('En espera de que le asignes un técnico.')
            ->salutation('Saludos,')
            ->subject('Nueva orden de servicio pendiente asignar técnico');
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
