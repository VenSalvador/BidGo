<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function showDashboard()
    {
        // You can pass any data needed by the Vue component here
        return Inertia::render('CarrierPages/CarrierDashboard',[
            'auth' => [
                'user' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'role' => auth()->user()->role,
                ]
            ]
        ]);
    }
}
