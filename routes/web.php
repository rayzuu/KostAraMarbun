<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Models\Room;

Route::get('/', function (\Illuminate\Http\Request $request) {

    $query = Room::query();

    // SEARCH NAMA
    if($request->search){

        $query->where('name', 'like', '%' . $request->search . '%');

    }

    // FILTER LOKASI
    if($request->location){

        $query->where('location', $request->location);

    }

    // FILTER STATUS
    if($request->status){

        $query->where('status', $request->status);

    }

    $rooms = $query->latest()
    ->take(6)
    ->get();

    // ambil lokasi unik
    $locations = Room::select('location')
        ->distinct()
        ->pluck('location');

    return view('layouts.landingPage', compact(
        'rooms',
        'locations'
    ));

});
Route::middleware(['auth', 'admin'])->group(function(){

    Route::resource('rooms', RoomController::class);

});

Route::get('/rooms/{room}',
    [RoomController::class, 'show'])
    ->name('rooms.show');

Route::get('/admin/dashboard', [RoomController::class, 'dashboard'])
    ->name('admin.dashboard');

Route::get('/kamar', [RoomController::class, 'allRooms'])
    ->name('rooms.all');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('rooms', RoomController::class);
require __DIR__.'/auth.php';
