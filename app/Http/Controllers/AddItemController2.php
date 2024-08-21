<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary;


class AddItemController2 extends Controller
{
    public function showAddItem()
    {
        return inertia('CarrierPages/AddItem2');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_client' => 'required|string|max:255',
            'item_weight' => 'required|numeric',
            'item_from' => 'required|string|max:255',
            'item_destination' => 'required|string|max:255',
            'item_pickup_time' => 'required|date',
            'item_dropoff_time' => 'nullable|date',
            'item_quote' => 'required|numeric',
            'item_image' => 'nullable|string',
            'item_length' => 'required|numeric',
            'item_width' => 'required|numeric',
            'item_height' => 'required|numeric',
            'item_status' => 'required|string',
            'vehicle_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Item::create([
            'user_id' => Auth::id(),
            'item_name' => $request->input('item_name'),
            'item_client' => $request->input('item_client'),
            'item_weight' => $request->input('item_weight'),
            'item_from' => $request->input('item_from'),
            'item_destination' => $request->input('item_destination'),
            'item_pickup_time' => $request->input('item_pickup_time'),
            'item_dropoff_time' => $request->input('item_dropoff_time'),
            'item_quote' => $request->input('item_quote'),
            'item_image' => $request->input('item_image'),
            'item_length' => $request->input('item_length'),
            'item_width' => $request->input('item_width'),
            'item_height' => $request->input('item_height'),
            'item_status' => $request->input('item_status'),
            'vehicle_type' => $request->input('vehicle_type'),
            'description' => $request->input('description'),
            'item_current_bids' => 0,
            'is_bid_placed' => false,
        ]);

        return redirect()->route('AddItem2')->with('success', 'Item added successfully!');
    }
}
