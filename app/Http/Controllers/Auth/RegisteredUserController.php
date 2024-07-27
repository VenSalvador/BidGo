<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Province;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Fetch provinces.
     */
    public function fetchProvinces()
    {
        try {
            $provinces = Province::all();
            return response()->json($provinces);
        } catch (\Exception $e) {
            \Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    \Log::info('Registration request received', $request->all());

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
        'role' => 'required|string',
        'province' => 'required|string',
        'mobile' => 'required|string',
        'postalcode' => 'required|string',
    ]);

    $province = is_array($request->province) ? $request->province['id'] : $request->province;
    
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'province' => $province,
            'mobile' => $request->mobile,
            'postalcode' => $request->postalcode,
        ]);

        // Optionally log in the user
        Auth::login($user);

        return redirect()->route('dashboard');
    } catch (\Exception $e) {
        \Log::error('Registration error: ' . $e->getMessage());
        \Log::error('Request Data:', $request->all()); // Log request data for debugging
        return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
    }
}
}
