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

        'price' => $request->price,

        'location' => $request->location,

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
    $totalRooms = Room::count();

    $availableRooms = Room::where(
        'status',
        'available'
    )->count();

    $bookedRooms = Room::where(
        'status',
        'booked'
    )->count();

    $latestRooms = Room::latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalRooms',
        'availableRooms',
        'bookedRooms',
        'latestRooms'
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

        'price' => $request->price,

        'location' => $request->location,

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

    if($request->location){

        $query->where('location',
            $request->location);

    }

    if($request->status){

        $query->where('status',
            $request->status);

    }

    $rooms = $query->latest()
        ->paginate(6);

    $locations = Room::select('location')
        ->distinct()
        ->pluck('location');

    return view('admin.rooms.room', compact(
        'rooms',
        'locations'
    ));
}
}