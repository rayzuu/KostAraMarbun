<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;

use App\Models\Room;


Route::post(
    '/midtrans/callback',
    [BookingController::class, 'callback']
);
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
Route::middleware(['auth'])->group(function(){

    Route::resource('rooms', RoomController::class);

    Route::get(
    '/admin/bookings/manual/create',
    [BookingController::class, 'createManual']
)->name('bookings.manual.create');

Route::post(
    '/admin/bookings/manual/store',
    [BookingController::class, 'storeManual']
)->name('bookings.manual.store');

Route::get(
    '/admin/bookings',
    [BookingController::class, 'index']
)->name('bookings.index');

Route::get(
    '/admin/bookings/{booking}/edit',
    [BookingController::class, 'edit']
)->name('bookings.edit');

Route::put(
    '/admin/bookings/{booking}',
    [BookingController::class, 'update']
)->name('bookings.update');

Route::delete(
    '/admin/bookings/{booking}',
    [BookingController::class, 'destroy']
)->name('bookings.destroy');
    
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

Route::delete(
    '/booking/{booking}/cancel',
    [BookingController::class, 'cancelBooking']
)->name('booking.cancel');

Route::get(
    '/admin/laporan',
    [ReportController::class, 'index']
)->name('report.index');

Route::get(
    '/admin/laporan/penyewa',
    [ReportController::class, 'reportPenyewa']
)->name('report.tenant');

Route::get(
    '/laporan/tunggakan',
    [ReportController::class, 'arrears']
)->name('report.arrears');

Route::get(
    '/admin/laporan/pembayaran/pdf',
    [ReportController::class, 'exportPaymentPdf']
)->name('report.payment.pdf');

Route::get(
    '/admin/laporan/penyewa/pdf',
    [ReportController::class, 'exportTenantPdf']
)->name('report.tenant.pdf');

Route::get(
    '/admin/laporan/tunggakan/pdf',
    [ReportController::class, 'exportArrearsPdf']
)->name('report.arrears.pdf');


});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function(){

    Route::get('/history-pembayaran',
        [BookingController::class, 'history']
    )->name('payment.history');

});

Route::middleware('auth')->group(function () {

    Route::get(
        '/payment/{payment}/receipt',
        [BookingController::class, 'downloadReceipt']
    )->name('payment.receipt');

});

Route::middleware(['auth'])->group(function(){
    Route::get('/ajukan-sewa', [BookingController::class, 'create'])
        ->name('booking.create');

    Route::post('/ajukan-sewa', [BookingController::class, 'store'])
        ->name('booking.store');

 });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('rooms', RoomController::class);

require __DIR__.'/auth.php';
