<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\MyBidsController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\AddItemController2;
use App\Http\Controllers\MyItemsController;
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
Route::get('/client-dashboard', [ClientController::class, 'showDashboard'])->name('ClientDashboard');
Route::get('/my-bid', [MyBidsController::class, 'showMyBids'])->name('MyBids');

Route::get('/provinces', [ProvinceController::class, 'index'])->name('provinces');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);


// Item Controller Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/vehicles', [ItemController::class, 'getVehicles'])->name('vehicles.index');
Route::post('/filter-by-vehicle-type', [ItemController::class, 'filterByVehicleType']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*Route::get('/my-bid', function () {
    return Inertia::render('MyBids');
})->name('MyBids');*/
Route::get('/lowest-bids', [BidController::class, 'lowestBids'])->name('bids.lowestBids');


Route::get('/items/{item}/bids', [MyItemsController::class, 'getItemBids']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/submit-bid', [ItemController::class, 'submitBid'])->name('submitBid');
    Route::get('/my-bids', [BidController::class, 'myBids'])->name('bids.myBids');
    Route::put('/bids/{id}', [BidController::class, 'update'])->name('bids.update');
    Route::delete('/bids/{id}', [BidController::class, 'destroy'])->name('bids.destroy');
    Route::get('/my-items', [MyItemsController::class, 'showMyItems'])->name('MyItems');
    Route::get('/lowest-bids', [BidController::class, 'lowestBids']);
    Route::get('/add-item2', [AddItemController2::class, 'showAddItem'])->name('AddItem2');
    Route::post('/add-item2', [AddItemController2::class, 'store'])->name('addItem2.store');
    Route::delete('/items/{itemId}', [MyItemsController::class, 'destroyItem']);

});

require __DIR__.'/auth.php';
