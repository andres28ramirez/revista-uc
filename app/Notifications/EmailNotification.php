<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting($this->email['greeting'])
                ->line($this->email['body'])
                ->action($this->email['actionText'], $this->email['actionURL'])
                ->line($this->email['thanks']);
    }

    public function toDatabase($notifiable)
    {
        return [
            'email_id' => $this->email['id']
        ];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
