<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
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

        // HITUNG PENYEWA ACTIVE
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'active')
        ->count();

        if($totalBooking >= $room->kapasitas){

            return back()->with(
                'error',
                'Kamar sudah penuh'
            );

        }

        // ORDER ID
        $orderId = 'BOOKING-' . time();

        // CREATE BOOKING
        $booking = Booking::create([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'monthly_price' => $room->price,

            'status' => 'inactive'

        ]);

        // CREATE PAYMENT
        $payment = Payment::create([

            'booking_id' => $booking->id,

            'midtrans_order_id' => $orderId,

            'payment_month' => now()->month,

            'payment_year' => now()->year,

            'amount' => $room->price,

            'status' => 'unpaid'

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

        // HITUNG PENYEWA ACTIVE
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'active')
        ->count();

        if($totalBooking >= $room->kapasitas){

            return back()->with(
                'error',
                'Kamar sudah penuh'
            );

        }

        // CREATE BOOKING
        $booking = Booking::create([

            'room_id' => $request->room_id,

            'name' => $request->name,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'start_date' => $request->start_date,

            'monthly_price' => $room->price,

            'status' => 'active'

        ]);

        // CREATE PAYMENT
        Payment::create([

            'booking_id' => $booking->id,

            'midtrans_order_id' => 'MANUAL-' . time(),

            'payment_month' => now()->month,

            'payment_year' => now()->year,

            'amount' => $room->price,

            'status' => 'paid',

            'paid_at' => now()

        ]);

        // UPDATE ROOM STATUS
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'active')
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
        $bookings = Booking::with([
            'room',
            'payments'
        ])
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

    $booking->load('payments');

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

    $room = Room::find($request->room_id);

    if(!$room){

        return back()->with(
            'error',
            'Kamar tidak ditemukan'
        );

    }

    // UPDATE BOOKING
    $booking->update([

        'room_id' => $request->room_id,

        'name' => $request->name,

        'phone' => $request->phone,

        'birth_place' => $request->birth_place,

        'birth_date' => $request->birth_date,

        'start_date' => $request->start_date,

        // STATUS PENYEWA
        'status' => $request->tenant_status

    ]);

    // PAYMENT TERAKHIR
    $payment = Payment::where(
        'booking_id',
        $booking->id
    )
    ->latest()
    ->first();

    if($payment){

        $payment->update([

            // STATUS PAYMENT
            'status' => $request->payment_status

        ]);

        // AUTO UPDATE PAID_AT
        if($request->payment_status == 'paid'){

            $payment->update([

                'paid_at' => now()

            ]);

        }else{

            $payment->update([

                'paid_at' => null

            ]);

        }

    }

    // UPDATE STATUS ROOM
    $totalBooking = Booking::where(
        'room_id',
        $room->id
    )
    ->where('status', 'active')
    ->count();

    if($totalBooking >= $room->kapasitas){

        $room->update([

            'status' => 'booked'

        ]);

    }else{

        $room->update([

            'status' => 'available'

        ]);

    }

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

        // DELETE PAYMENT
        Payment::where(
            'booking_id',
            $booking->id
        )->delete();

        // DELETE BOOKING
        $booking->delete();

        // UPDATE ROOM STATUS
        $totalBooking = Booking::where(
            'room_id',
            $room->id
        )
        ->where('status', 'active')
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

        Payment::where(
            'booking_id',
            $booking->id
        )->delete();

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

            // CARI PAYMENT
            $payment = Payment::where(
                'midtrans_order_id',
                $request->order_id
            )->first();

            if(!$payment){

                return response()->json([
                    'message' => 'Payment tidak ditemukan'
                ], 404);

            }

            // CARI BOOKING
            $booking = Booking::find(
                $payment->booking_id
            );

            // PAYMENT SUCCESS
            if(
                $request->transaction_status == 'settlement' ||
                $request->transaction_status == 'capture'
            ){

                $payment->update([

                    'status' => 'paid',

                    'paid_at' => now()

                ]);

                $booking->update([

                    'status' => 'active'

                ]);

                // UPDATE ROOM STATUS
                $room = Room::find($booking->room_id);

                $totalBooking = Booking::where(
                    'room_id',
                    $room->id
                )
                ->where('status', 'active')
                ->count();

                if($totalBooking >= $room->kapasitas){

                    $room->update([

                        'status' => 'booked'

                    ]);

                }

            }

            // PAYMENT FAILED / CANCEL / EXPIRE
            if(
                $request->transaction_status == 'expire' ||
                $request->transaction_status == 'cancel' ||
                $request->transaction_status == 'deny'
            ){

                $payment->update([

                    'status' => 'unpaid'

                ]);

                $booking->update([

                    'status' => 'inactive'

                ]);

            }

        }

        return response()->json([
            'message' => 'Callback success'
        ]);
    }

}