<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Item;

class AddItemController extends Controller
{
    public function showAddItem()
    {
        return Inertia::render('CarrierPages/AddItem');
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'item_name' => 'required|string|max:255',
                'item_quote' => 'required|numeric',
                'item_pickup_time' => 'required|date',
                'item_dropoff_time' => 'required|date',
                'item_from' => 'required|string|max:255',
                'item_destination' => 'required|string|max:255',
                'item_weight' => 'required|numeric',
                'item_height' => 'required|numeric',
                'item_width' => 'required|numeric',
                'item_length' => 'required|numeric',
                'description' => 'required|string',
                'vehicle_type' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
            ]);

            // Add default values for item_path and item_status
            $validatedData['item_image'] = 'path/path';
            $validatedData['item_status'] = 'pending';
            $validatedData['item_current_bids'] = 0;
            $validatedData['is_bid_placed'] = 0;



            $item = Item::create($validatedData + [
                'vehicle_type' => $request->input('vehicle.vehicle_type'),
                'item_path' => 'path/path',
                'item_status' => 'pending',
                'is_bid_placed' => 0,
                'item_current_bids'=>0,
            ]);

            // Log the creation for debugging
            \Log::info('Item created successfully', ['item' => $item]);

            // Return a response
            return response()->json(['success' => true, 'item' => $item], 201);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating item', ['error' => $e->getMessage()]);

            // Return an error response
            return response()->json(['success' => false, 'error' => 'An error occurred while creating the item.'], 500);
        }
    }

}
