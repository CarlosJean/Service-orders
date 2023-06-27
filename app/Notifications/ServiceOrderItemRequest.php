<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceOrderItemRequest extends Notification
{
    use Queueable;

    protected $maintenanceSupervisor;
    protected $serviceOrderNumber;
    /**
     * Create a new notification instance.
     */
    public function __construct($maintenanceSupervisor, $serviceOrderNumber)
    {
        $this->maintenanceSupervisor = $maintenanceSupervisor;
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
            ->line('Una nueva solicitud de artículos requiere de tu aprobación.')
            ->line(
                $this->maintenanceSupervisor . ' realizó una solicitud de artículos para la orden número '
                    . $this->serviceOrderNumber.'.'
            )
            ->salutation('--')
            ->subject('Aprobación solicitud de materiales');
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
