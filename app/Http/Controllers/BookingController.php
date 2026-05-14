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

    public function createManual()
    {
        $rooms = Room::where(
            'status',
            'available'
        )->get();

        return view(
            'booking.createManual',
            compact('rooms')
        );
    }

    public function store(Request $request)
    {
        $room = Room::find($request->room_id);

        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )->count();

        if($totalBooking >= $room->kapasitas){

            return back()->with(
                'error',
                'Kamar sudah penuh'
            );

        }

        Booking::create([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'status' => 'pending'

        ]);

        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )->count();

        if($totalBooking >= $room->kapasitas){

            $room->update([

                'status' => 'booked'

            ]);

        }

        return redirect()
            ->route('booking.create')
            ->with(
                'success',
                'Pengajuan sewa berhasil dikirim'
            );
    }

    public function storeManual(Request $request)
    {
        $room = Room::find($request->room_id);

        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )->count();

        if($totalBooking >= $room->kapasitas){

            return back()->with(
                'error',
                'Kamar sudah penuh'
            );

        }

        Booking::create([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'status' => 'approved'

        ]);

        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )->count();

        if($totalBooking >= $room->kapasitas){

            $room->update([

                'status' => 'booked'

            ]);

        }

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Data penyewa berhasil ditambahkan'
            );
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

    public function edit(Booking $booking)
    {
        $rooms = Room::all();

        return view(
            'booking.edit',
            compact(
                'booking',
                'rooms'
            )
        );
    }

    public function update(
        Request $request,
        Booking $booking
    ){

        $booking->update([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'status' => $request->status

        ]);

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Data penyewa berhasil diupdate'
            );
    }

    public function destroy(Booking $booking)
    {
        $room = Room::find($booking->room_id);

        $booking->delete();

        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )->count();

        if($totalBooking < $room->kapasitas){

            $room->update([

                'status' => 'available'

            ]);

        }

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Data penyewa berhasil dihapus'
            );
    }
}