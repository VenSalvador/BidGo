<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Bid;


class MyItemsController extends Controller
{
    public function showMyItems(Request $request)
    {
        $userId = $request->user()->id;

        $items = Item::where('user_id', $userId)->get();

        return Inertia::render('CarrierPages/MyItems', [
            'items' => $items
        ]);
    }

    public function getItemBids($itemId)
    {
        $bids = Bid::where('item_id', $itemId)
                    ->with('user') // Include user details
                    ->get();

        return response()->json($bids);
    }
}
