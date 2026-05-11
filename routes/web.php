<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Models\Room;

Route::get('/', function (\Illuminate\Http\Request $request) {

    $query = Room::query();

    // SEARCH NAMA
    if($request->search){

        $query->where('name', 'like', '%' . $request->search . '%');

    }

    

    // FILTER STATUS
    if($request->status){

        $query->where('status', $request->status);

    }

    $rooms = $query->latest()
    ->take(6)
    ->get();



    return view('layouts.landingPage', compact(
        'rooms',
        
    ));

});
Route::middleware(['auth', 'admin'])->group(function(){

    Route::resource('rooms', RoomController::class);

});
Route::get('/ajukan-sewa', [BookingController::class, 'create'])
    ->name('booking.create');

Route::post('/ajukan-sewa', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/admin/dataBooking',
    [BookingController::class, 'index'])
    ->name('admin.dataBooking');

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
