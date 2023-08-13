<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceOrderItemsRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $serviceOrdernumber;
    /**
     * Create a new notification instance.
     */
    public function __construct($serviceOrdernumber)
    {
        $this->serviceOrdernumber = $serviceOrdernumber; 
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
            ->greeting('Hola '.$notifiable->name.'!')
            ->line('Se han solicitado materiales para una orden de servicio que requieren de tu atención.')
            ->line('La orden de servicio es la número '.$this->serviceOrdernumber.'.')
            ->salutation('--')
            ->subject('Nueva solicitud de materiales para orden de servicio');
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
