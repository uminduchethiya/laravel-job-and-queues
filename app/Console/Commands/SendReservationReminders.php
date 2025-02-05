<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderJob;
use App\Models\Reservation;
use App\Notifications\ReservationReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:send-reminders';
    protected $description = 'Send email reminders for upcoming reservations';

    public function handle()
    {
        $now = now()->format('Y-m-d H:i'); // Current time
    
        $reservations = Reservation::whereRaw("DATE_FORMAT(reservation_time, '%Y-%m-%d %H:%i') = ?", [$now])
            ->where('notified', false)
            ->get();
    
        foreach ($reservations as $reservation) {
            Queue::push(new SendReminderJob($reservation));
            $reservation->update(['notified' => true]); // Mark as notified
        }
    
        $this->info('Reminders queued successfully!');
    }
}