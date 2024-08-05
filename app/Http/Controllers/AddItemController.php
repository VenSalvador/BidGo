<?php
// app/Http/Controllers/AddItemController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Item;

class AddItemController extends Controller
{
    public function showAddItem()
    {
        // You can pass any data needed by the Vue component here
        return Inertia::render('CarrierPages/AddItem');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_quote' => 'required|numeric',
            'item_pickup_time' => 'required|date',
            'item_dropoff_time' => 'required|date',
            'item_pickup_location' => 'required|string|max:255',
            'item_destination' => 'required|string|max:255',
            'item_weight' => 'required|numeric',
            'item_height' => 'required|numeric',
            'item_width' => 'required|numeric',
            'item_length' => 'required|numeric',
            'description' => 'required|string',
            'vehicle_type' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        // Create a new item in the database
        $item = Item::create($validatedData);

        // Return a response
        return response()->json(['success' => true, 'item' => $item], 201);
    }
}
