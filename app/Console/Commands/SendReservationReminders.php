<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Notifications\ReservationReminderNotification;
use Illuminate\Console\Command;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:send-reminders';
    protected $description = 'Send email reminders for upcoming reservations';

    public function handle()
    {
        $reservations = Reservation::whereBetween('reservation_time', [
            now(), now()->addHours(24)
        ])->get();

        foreach ($reservations as $reservation) {
            $reservation->notify(new ReservationReminderNotification($reservation));
        }

        $this->info('Reminders sent successfully!');
    }
}