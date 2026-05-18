<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\Booking;
use App\Models\Payment;
class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

 public function store(Request $request)
{
    $thumbnail = null;

    // CREATE ROOM
    $room = Room::create([

        'name' => $request->name,

        'description' => $request->description,

        'price' => str_replace('.', '', $request->price),

        'status' => 'available'
        

    ]);

    // MULTIPLE IMAGE
    if($request->hasFile('images')){

        foreach($request->file('images') as $index => $image){

            $path = $image->store(
                'rooms/gallery',
                'public'
            );

            // IMAGE PERTAMA = THUMBNAIL
            if($index == 0){

                $thumbnail = $path;

            }

            // SAVE GALLERY
            RoomImage::create([

                'room_id' => $room->id,

                'image' => $path

            ]);

        }

    }

    // UPDATE THUMBNAIL
    $room->update([
        'image' => $thumbnail
    ]);

    return redirect()->route('rooms.index')
        ->with('success', 'Kamar berhasil ditambahkan');
}
public function show(Room $room)
{
    $room->load('images');

    return view(
        'admin.rooms.detail',
        compact('room')
    );
}
public function dashboard()
{
        // TOTAL SELURUH KAMAR FISIK
    $totalKamar = Room::sum('kapasitas');

    // TOTAL PENGHUNI ACTIVE
    $totalPenghuni = \App\Models\Booking::where(
        'status',
        'active'
    )->count();

    // SISA KAMAR
    $kamarTersedia = $totalKamar - $totalPenghuni;

    // KAMAR TERISI
    $kamarPenuh = $totalPenghuni;
    

    // TOTAL PENDAPATAN
    $totalPendapatan = \App\Models\Payment::where(
        'status',
        'paid'
    )->sum('amount');

    // BULAN INI
    $pendapatanBulanIni = \App\Models\Payment::where(
        'status',
        'paid'
    )
    ->whereMonth('paid_at', now()->month)
    ->whereYear('paid_at', now()->year)
    ->sum('amount');

    // BULAN LALU
    $pendapatanBulanLalu = \App\Models\Payment::where(
        'status',
        'paid'
    )
    ->whereMonth('paid_at', now()->subMonth()->month)
    ->whereYear('paid_at', now()->subMonth()->year)
    ->sum('amount');

    // ROOM TERBARU
    $latestRooms = Room::latest()
        ->take(5)
        ->get();

    // PAYMENT TERBARU
    $latestPayments = \App\Models\Payment::with([
        'booking.room'
    ])
    ->latest()
    ->take(5)
    ->get();

    return view('admin.dashboard', compact(

        'totalKamar',
        'totalPenghuni',
        'kamarTersedia',
        'kamarPenuh',
        'totalPendapatan',
        'pendapatanBulanIni',
        'pendapatanBulanLalu',
        'latestRooms',
        'latestPayments'

    ));
}
public function edit(Room $room)
{
    return view('admin.rooms.edit', compact('room'));
}

public function update(Request $request, Room $room)
{
    $thumbnail = $room->image;

    $room->update([

        'name' => $request->name,

        'description' => $request->description,

       'price' => str_replace('.', '', $request->price),


        'status' => $request->status

    ]);

    // MULTIPLE IMAGE
    if($request->hasFile('images')){

        foreach($request->file('images') as $index => $image){

            $path = $image->store(
                'rooms/gallery',
                'public'
            );

            // JIKA BELUM ADA THUMBNAIL
            if(!$thumbnail){

                $thumbnail = $path;

            }

            RoomImage::create([

                'room_id' => $room->id,

                'image' => $path

            ]);

        }

        $room->update([
            'image' => $thumbnail
        ]);

    }

    return redirect()->route('rooms.index')
        ->with('success', 'Kamar berhasil diupdate');
}
public function destroy(Room $room)
{
    $room->delete();

    return redirect()->route('rooms.index')
        ->with('success', 'Kamar berhasil dihapus');
}
public function allRooms(Request $request)
{
    $query = Room::query();

    if($request->search){

        $query->where('name', 'like',
            '%' . $request->search . '%');

    }

   

    if($request->status){

        $query->where('status',
            $request->status);

    }

    $rooms = $query->latest()
        ->paginate(6);

    

    return view('admin.rooms.room', compact(
        'rooms',
    ));
}
}