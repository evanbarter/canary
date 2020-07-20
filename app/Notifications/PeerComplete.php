<?php

namespace App\Notifications;

use App\Peer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeerComplete extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var App\Peer */
    protected Peer $peer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Peer $peer)
    {
        $this->peer = $peer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.peer.complete', ['peer' => $this->peer]);
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
            'peer' => $this->peer,
        ];
    }
}
