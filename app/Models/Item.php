<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'item_name',
        'item_client',
        'item_weight',
        'item_from',
        'item_destination',
        'item_pickup_time',
        'item_dropoff_time',
        'item_quote',
        'item_image',
        'item_length',
        'item_width',
        'item_height',
        'item_status',
        'item_current_bids',
        'is_bid_placed',
        'description',
        'vehicle_type',
        'created_at',
        'updated_at'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }


public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}



}
