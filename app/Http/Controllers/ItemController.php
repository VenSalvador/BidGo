<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vehicle;
use App\Models\Bid;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return Inertia::render('Items/Index', ['items' => $items]);
    }

    public function getVehicles()
    {
        $vehicles = Vehicle::all();
        return Inertia::render('Vehicles/Index', ['vehicles' => $vehicles]);
    }

    public function submitBid(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'bid_amount' => 'required|numeric|min:0',
        ]);

        $bid = Bid::create([
            'item_id' => $validatedData['item_id'],
            'bid_amount' => $validatedData['bid_amount'],
            'user_id' => 1, // Assign user_id as 1
        ]);

        return redirect()->back()->with('message', 'Bid submitted successfully!');
    }

    public function filterByVehicleType(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle_type' => 'required|string',
        ]);

        $vehicleType = $validatedData['vehicle_type'];
        $items = Item::where('vehicle_type', $vehicleType)->get();

        return Inertia::render('Items/Index', ['items' => $items]);
    }
}

