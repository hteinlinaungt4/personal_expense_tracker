<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PdfGeneratedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $filename;
     public $downloadLink;
    public function __construct($filename,$downloadLink)
    {
        $this->filename = $filename;
        $this->downloadLink = $downloadLink;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your Income PDF has been generated successfully.',
            'url' => $this->downloadLink,
            'filename' => $this->filename
        ];
    }



}
