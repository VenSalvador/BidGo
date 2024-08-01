<?php
// CarrierController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class AddItemController extends Controller
{
    public function showAddItem()
    {
        // You can pass any data needed by the Vue component here
        return Inertia::render('CarrierPages/AddItem');
    }
}
