<?php
// CarrierController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class MyBidsController extends Controller
{
    public function showMyBids()
    {
        // You can pass any data needed by the Vue component here
        return Inertia::render('CarrierPages/MyBids');
    }
}
