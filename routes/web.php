<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CarrierController; // Ensure you have this controller
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

    Route::get('/carrier-dashboard', [CarrierController::class, 'showDashboard'])->name('CarrierDashboard');

// Item Controller Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/vehicles', [ItemController::class, 'getVehicles'])->name('vehicles.index');
Route::post('/submit-bid', [ItemController::class, 'submitBid'])->name('submit.bid');
Route::post('/filter-by-vehicle', [ItemController::class, 'filterByVehicleType'])->name('filter.by.vehicle');

// Bid Controller Routes
Route::get('/my-bids', [BidController::class, 'myBids'])->name('bids.myBids');
Route::post('/bids/{id}', [BidController::class, 'update'])->name('bids.update');
Route::delete('/bids/{id}', [BidController::class, 'destroy'])->name('bids.destroy');
Route::get('/lowest-bids', [BidController::class, 'lowestBids'])->name('bids.lowestBids');

// Additional routes

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
