<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BrevoMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    public function create() { return Inertia::render('Auth/Register'); }

    public function store(Request $request, BrevoMailService $brevo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'is_pro' => 'boolean',
            'company_name' => 'required_if:is_pro,true|nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_pro' => $request->is_pro,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        // Envoi du mail de bienvenue via Brevo
        $brevo->sendWelcomeEmail($user);

        return redirect()->route('customer.dashboard');
    }
}