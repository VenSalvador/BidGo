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


            // Handle image upload if any
            if ($request->hasFile('item_image')) {
                $validatedData['item_image'] = $request->file('item_image')->store('images/items', 'public');
            } else {
                $validatedData['item_image'] = 'default/path/to/image.png';  // Default image or placeholder
            }

            // Add default values for item_status and bids
            $validatedData['item_status'] = 'pending';
            $validatedData['item_current_bids'] = 0;
            $validatedData['is_bid_placed'] = 0;

            // Store the item in the database
            $item = Item::create($validatedData);

            // Log the creation for debugging
            \Log::info('Item created successfully', ['item' => $item]);

            // Return a success response
            return response()->json(['success' => true, 'item' => $item], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating item', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'An error occurred while creating the item.'], 500);
        }
    }

}
