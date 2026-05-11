<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class BookingController extends Controller
{

    public function create(Request $request)
    {
        $rooms = Room::where(
            'status',
            'available'
        )->get();

        $selectedRoom = $request->room;

        return view('booking.create', compact(
            'rooms',
            'selectedRoom'
        ));
    }

    public function store(Request $request)
{
    Booking::create([

        'room_id' => $request->room_id,

        'name' => $request->name,

        'phone' => $request->phone,

        'birth_place' => $request->birth_place,

        'birth_date' => $request->birth_date,

        'start_date' => $request->start_date,

        'status' => 'pending'

    ]);

    return redirect()
        ->route('booking.create')
        ->with('success',
            'Pengajuan sewa berhasil dikirim');
}
public function index()
{
    $bookings = Booking::with('room')
        ->latest()
        ->get();

    return view(
        'admin.dataBooking',
        compact('bookings')
    );
}
}