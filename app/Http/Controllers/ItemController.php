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
        $items = Item::with('user:id,name')
                     ->withCount('bids') // This will count bids related to each item
                     ->get();
        return response()->json($items);
    }



    public function getVehicles()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    public function submitBid(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'bid_amount' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();

        $bid = Bid::create([
            'item_id' => $validatedData['item_id'],
            'bid_amount' => $validatedData['bid_amount'],
            'user_id' => $user->id, // Use authenticated user's ID
        ]);

        return response()->json(['message' => 'Bid submitted successfully!']);
    }

    public function filterByVehicleType(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle_type' => 'required|string',
        ]);

        $vehicleType = $validatedData['vehicle_type'];
        $items = Item::with('user:id,name')
                     ->where('vehicle_type', $vehicleType)
                     ->get();

        return response()->json($items);
    }

}
