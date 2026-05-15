<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomImage;
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
    $room = Room::first();

    $totalPenghuni = \App\Models\Booking::where(
        'status',
        'paid'
    )->count();

    $kapasitas = $room->kapasitas ?? 0;

    $sisaKamar = $kapasitas - $totalPenghuni;

    $kamarTerisi = $totalPenghuni;

    $totalPendapatan = \App\Models\Booking::where(
        'status',
        'paid'
    )->count() * 800000;

    $latestRooms = Room::latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(

        'totalPenghuni',
        'sisaKamar',
        'kamarTerisi',
        'latestRooms',
        'totalPendapatan'

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