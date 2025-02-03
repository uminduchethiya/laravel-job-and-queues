<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('reservations');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email',
            'reservation_time' => 'required|date',
        ]);

        Reservation::create($request->all());

        return back()->with('success', 'Reservation made successfully!');
    }
}