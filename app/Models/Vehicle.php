<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_name',
        'vehicle_type',
        'capacity',
        'availability'
    ];

    public function bids()
{
    return $this->hasMany(Bid::class);
}

}
