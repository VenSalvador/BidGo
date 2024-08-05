<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    public function myBids(Request $request)
    {
        $userId = $request->user()->id;

        $bids = Bid::where('user_id', $userId)
                    ->with(['item.user']) // Eager load the user relationship through the item relationship
                    ->get();

        return response()->json($bids);
    }

    public function update(Request $request, $id)
    {
        $bid = Bid::find($id);
        if (!$bid) {
            return response()->json(['message' => 'Bid not found'], 404);
        }

        $request->validate([
            'bid_amount' => 'required|numeric|min:0',
        ]);

        $bid->bid_amount = $request->input('bid_amount');
        $bid->save();

        return response()->json($bid); // Return the updated bid
    }

    public function destroy($id)
    {
        $bid = Bid::find($id);
        if (!$bid) {
            return response()->json(['message' => 'Bid not found'], 404);
        }

        $bid->delete();

        return response()->json(['message' => 'Bid deleted successfully']);
    }

    public function lowestBids()
    {
        $lowestBids = Bid::select('item_id', DB::raw('MIN(bid_amount) as lowest_bid'))
            ->groupBy('item_id')
            ->get();

        return response()->json($lowestBids);
    }
}
