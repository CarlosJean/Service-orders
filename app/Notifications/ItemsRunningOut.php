<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ItemsRunningOut extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $itemsRunningOut)
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
    public function toMail(object $notifiable): MailMessage
    {
        $itemsRunningOutEmail = (new MailMessage())
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Los siguientes materiales están a punto de agotarse: ');

        foreach ($this->itemsRunningOut as $item) {
            $itemsRunningOutEmail->line('*' . $item->name . '. Referencia: ' . $item->reference);
        }

        $itemsRunningOutEmail->line('*' . $item->name . '. Referencia: ' . $item->reference)
            ->salutation('--')
            ->subject('Materiales a punto de agotarse');

        return $itemsRunningOutEmail;
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
