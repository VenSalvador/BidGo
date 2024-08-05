<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function showDashboard()
    {
        return Inertia::render('ClientPages/ClientDashboard');
    }
}
