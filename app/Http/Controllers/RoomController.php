<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
     $request->validate([

    'images'      => 'required|array|min:1', 
    'images.*'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ],[
    'images.required' => 'Kamu wajib mengunggah minimal satu gambar kamar.',
    'images.*.image'  => 'File yang diunggah harus berupa gambar.',
    'images.*.mimes'  => 'Format gambar harus berupa: jpg, jpeg, png, atau webp.',
    'images.*.max'    => 'Ukuran tiap gambar tidak boleh lebih dari 2MB.',
    ]);

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

public function getSisaKamarAttribute()
{
    $aktif = $this->bookings()
        ->where('status', 'active')
        ->count();

    return max(0, $this->kapasitas - $aktif);
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

    $request->validate([

        'name'        => 'required|string|max:255',
        'description' => 'required',
        'price'       => 'required',

        'kapasitas'   => 'required|integer|min:1',

        // OPTIONAL
        'images'      => 'nullable|array',
        'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',

    ], [

        'images.*.image' => 'File harus berupa gambar.',
        'images.*.mimes' => 'Format gambar harus jpg/jpeg/png/webp.',
        'images.*.max'   => 'Ukuran gambar maksimal 2MB.',

    ]);

    
    $penghuniAktif = $room->bookings()
        ->where('status', 'active')
        ->count();

    $status = $penghuniAktif >= $request->kapasitas
        ? 'booked'
        : 'available';

    // UPDATE ROOM
    $room->update([

        'name'        => $request->name,

        'description' => $request->description,

        'price'       => str_replace('.', '', $request->price),

        'kapasitas'   => $request->kapasitas,

        'status'      => $status,

    ]);

    
// HAPUS GAMBAR LAMA
if($request->has('delete_images')){

    $imagesToDelete = RoomImage::whereIn(
        'id',
        $request->delete_images
    )->get();

    foreach($imagesToDelete as $img){

        // HAPUS FILE
        if(Storage::disk('public')->exists($img->image)){

            Storage::disk('public')->delete($img->image);

        }

        // HAPUS DATABASE
        $img->delete();

    }

}
    // UPLOAD GAMBAR BARU
    if($request->hasFile('images')){

        foreach($request->file('images') as $image){

            $path = $image->store(
                'rooms/gallery',
                'public'
            );

            // SET THUMBNAIL
            if(!$thumbnail){

                $thumbnail = $path;

            }

            RoomImage::create([

                'room_id' => $room->id,

                'image' => $path

            ]);

        }

    }

    // UPDATE THUMBNAIL BARU
    $firstImage = RoomImage::where('room_id', $room->id)->first();

    $room->update([

        'image' => $firstImage?->image

    ]);

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