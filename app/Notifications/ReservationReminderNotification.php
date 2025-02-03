<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reservation Reminder')
            ->greeting('Hello, ' . $this->reservation->customer_name)
            ->line('This is a reminder for your upcoming reservation.')
            ->line('Reservation Date: ' . $this->reservation->reservation_time)
            ->line('We look forward to serving you!')
            ->action('View Reservation', url('/'))
            ->line('Thank you for choosing us!');
    }
}
