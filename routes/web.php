<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/landing-page', function () {
    return Inertia::render('LandingPage');
});

//Item Controller Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/vehicles', [ItemController::class, 'getVehicles'])->name('vehicles.index');
Route::post('/submit-bid', [ItemController::class, 'submitBid'])->name('submit.bid');
Route::post('/filter-by-vehicle', [ItemController::class, 'filterByVehicleType'])->name('filter.by.vehicle');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
