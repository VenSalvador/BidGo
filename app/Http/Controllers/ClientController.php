<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function showDashboard()
    {
        return Inertia::render('ClientPages/ClientDashboard',[
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
