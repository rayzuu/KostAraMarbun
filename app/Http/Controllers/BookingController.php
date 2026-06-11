<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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

    $orderId = 'BOOKING-' . time();

    $booking = Booking::create([

        'user_id' => auth()->id(),

        'room_id' => $request->room_id,

        'name' => $request->name,

        'phone' => $request->phone,

        'birth_place' => $request->birth_place,

        'birth_date' => $request->birth_date,

        'start_date' => $request->start_date,

        'monthly_price' => $room->price,

        'status' => 'inactive'

    ]);

    $payment = Payment::create([

    'booking_id' => $booking->id,

    'midtrans_order_id' => $orderId,

    'payment_month' => now()->month,

    'payment_year' => now()->year,

    'amount' => $room->price,

    'status' => 'unpaid'

]);

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

public function history()
{
    $payments = Payment::with([
            'booking.room'
        ])
        ->whereHas('booking', function($q){

            $q->where(
                'user_id',
                auth()->id()
            );

        })
        ->latest()
        ->get();

    return view(
        'booking.history',
        compact('payments')
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

    // UPDATE DATA BOOKING
    $booking->update([

        'room_id' => $request->room_id,

        'name' => $request->name,

        'phone' => $request->phone,

        'birth_place' => $request->birth_place,

        'birth_date' => $request->birth_date,

        'start_date' => $request->start_date,

        'end_date' => $request->end_date,

        'status' => $request->tenant_status

    ]);


    //UPDATE TANGGAL PENYEWA
    if($request->tenant_status == 'active'){

    $booking->update([

        'end_date' => null

    ]);

    }

    if(
        $request->tenant_status == 'inactive'
        && !$booking->end_date
    ){

        $booking->update([

            'end_date' => now()->toDateString()

        ]);

    }

    
    $currentMonth = now()->month;
    $currentYear  = now()->year;

    // Cek payment bulan ini
    $existingPayment = Payment::where(
        'booking_id',
        $booking->id
    )
    ->where('payment_month', $currentMonth)
    ->where('payment_year', $currentYear)
    ->first();

    // Kalau belum ada payment bulan ini
    if(!$existingPayment){

        Payment::create([

            'booking_id' => $booking->id,

            'midtrans_order_id' => 'MANUAL-' . time(),

            'payment_month' => $currentMonth,

            'payment_year' => $currentYear,

            'amount' => $booking->monthly_price,

            'status' => $request->payment_status,

            'paid_at' => $request->payment_status == 'paid'
                ? now()
                : null

        ]);

    }else{

        $existingPayment->update([

            'status' => $request->payment_status,

            'paid_at' => $request->payment_status == 'paid'
                ? now()
                : null

        ]);

    }

    

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

        $payment = Payment::where(
            'midtrans_order_id',
            $request->order_id
        )->first();

        if(!$payment){

            return response()->json([
                'message' => 'Payment tidak ditemukan'
            ], 404);

        }

        $booking = Booking::find(
            $payment->booking_id
        );


        $vaNumber = null;
        $bank = null;

        if(isset($request->va_numbers[0])){

            $vaNumber = $request->va_numbers[0]['va_number'];
            $bank = $request->va_numbers[0]['bank'];

        }

        
        elseif(isset($request->permata_va_number)){

            $vaNumber = $request->permata_va_number;
            $bank = 'permata';

        }

        elseif($request->payment_type == 'echannel'){

            $bank = 'mandiri';
            $vaNumber = $request->bill_key ?? null;

        }


        if($request->transaction_status == 'pending'){

            $payment->update([

                'status' => 'unpaid',

                'transaction_status' => 'pending',

                'payment_type' => $request->payment_type,

                'bank' => $bank,

                'va_number' => $vaNumber

            ]);

        }


        if(
            $request->transaction_status == 'settlement' ||
            $request->transaction_status == 'capture'
        ){

            $payment->update([

                'status' => 'paid',

                'paid_at' => now(),

                'transaction_status' => 'settlement',

                'payment_type' => $request->payment_type,

                'bank' => $bank,

                'va_number' => $vaNumber

            ]);

            $booking->update([

                'status' => 'active'

            ]);

            $room = Room::find(
                $booking->room_id
            );

            $totalBooking = Booking::where(
                'room_id',
                $room->id
            )
            ->where(
                'status',
                'active'
            )
            ->count();

            if($totalBooking >= $room->kapasitas){

                $room->update([

                    'status' => 'booked'

                ]);

            }

        }


        if(
            $request->transaction_status == 'expire' ||
            $request->transaction_status == 'cancel' ||
            $request->transaction_status == 'deny'
        ){

            $payment->update([

                'transaction_status' => $request->transaction_status,

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

    public function downloadReceipt(Payment $payment)
        {
            // Security
            if (
                $payment->booking->user_id != auth()->id()
            ) {
                abort(403);
            }

            if ($payment->status != 'paid') {
                abort(404);
            }

            $pdf = Pdf::loadView(
                'pdf.receipt',
                compact('payment')
            );

            return $pdf->download(
                'Bukti-Pembayaran-' .
                $payment->id .
                '.pdf'
            );
        }

}