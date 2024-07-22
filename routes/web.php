<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\MyBidsController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ])->name('LandingPage');
});

Route::get('/carrier-dashboard', [CarrierController::class, 'showDashboard'])->name('CarrierDashboard');
Route::get('/my-bid', [MyBidsController::class, 'showMyBids'])->name('MyBids');

Route::get('/provinces', [RegisteredUserController::class, 'getProvinces'])->name('provinces');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/carrier-dashboard', [CarrierController::class, 'showDashboard'])->name('CarrierDashboard');

// Item Controller Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/vehicles', [ItemController::class, 'getVehicles'])->name('vehicles.index');
Route::post('/filter-by-vehicle', [ItemController::class, 'filterByVehicleType'])->name('filter.by.vehicle');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*Route::get('/my-bid', function () {
    return Inertia::render('MyBids');
})->name('MyBids');*/


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/submit-bid', [ItemController::class, 'submitBid'])->name('submitBid');
    Route::get('/my-bids', [BidController::class, 'myBids'])->name('bids.myBids');
    Route::post('/bids/{id}', [BidController::class, 'update'])->name('bids.update');
    Route::delete('/bids/{id}', [BidController::class, 'destroy'])->name('bids.destroy');
    Route::get('/lowest-bids', [BidController::class, 'lowestBids'])->name('bids.lowestBids');
});

require __DIR__.'/auth.php';
