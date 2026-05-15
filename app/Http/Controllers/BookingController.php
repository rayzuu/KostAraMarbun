<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

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

        if(!$room){

            return back()->with(
                'error',
                'Kamar tidak ditemukan'
            );

        }

        // HITUNG YANG SUDAH PAID AJA
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'paid')
        ->count();

        if($totalBooking >= $room->kapasitas){

            return back()->with(
                'error',
                'Kamar sudah penuh'
            );

        }

        // ORDER ID
        $orderId = 'BOOKING-' . time();

        // SIMPAN BOOKING
        $booking = Booking::create([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'status' => 'unpaid',

            'payment_status' => 'unpaid',

            'midtrans_order_id' => $orderId

        ]);

        // MIDTRANS PARAMS
        $params = [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => $room->price,

            ],

            'customer_details' => [

                'first_name' => $booking->name,

                'phone' => $booking->phone,

            ],

        ];

        // SNAP TOKEN
        $snapToken = Snap::getSnapToken($params);

        return view('booking.payment', compact(
            'snapToken',
            'booking',
            'room'
        ));
    }

    public function storeManual(Request $request)
    {
        $room = Room::find($request->room_id);

        if(!$room){

            return back()->with(
                'error',
                'Kamar tidak ditemukan'
            );

        }

        // HITUNG YANG SUDAH PAID AJA
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'paid')
        ->count();

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

            'status' => 'paid',

            'payment_status' => 'paid'

        ]);

        // UPDATE STATUS ROOM
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'paid')
        ->count();

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
        )
        ->where('status', 'paid')
        ->count();

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
    public function cancelBooking(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking dibatalkan'
        ]);
    }

    // CALLBACK MIDTRANS
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $hashed = hash(
            "sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if($hashed == $request->signature_key){

            $booking = Booking::where(
                'midtrans_order_id',
                $request->order_id
            )->first();

            if(!$booking){

                return response()->json([
                    'message' => 'Booking tidak ditemukan'
                ], 404);

            }

            // PAYMENT SUCCESS
            if(
                $request->transaction_status == 'settlement' ||
                $request->transaction_status == 'capture'
            ){

                $booking->update([

                    'payment_status' => 'paid',

                    'status' => 'paid',

                ]);

                // UPDATE STATUS ROOM
                $room = Room::find($booking->room_id);

                $totalBooking = Booking::where(
                    'room_id',
                    $room->id
                )
                ->where('status', 'paid')
                ->count();

                if($totalBooking >= $room->kapasitas){

                    $room->update([

                        'status' => 'booked'

                    ]);

                }

            }

            // PAYMENT FAILED / EXPIRE
            if(
                $request->transaction_status == 'expire' ||
                $request->transaction_status == 'cancel'
            ){

                $booking->update([

                    'payment_status' => 'unpaid',

                    'status' => 'unpaid'

                ]);

            }

        }

        return response()->json([
            'message' => 'Callback success'
        ]);
    }

}