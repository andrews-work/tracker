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
use Illuminate\Support\Facades\Log;


class RegisteredUserController extends Controller {
    // Display the registration view.
    public function create(): Response {

        return Inertia::render('Auth/Register');
    }

    // Handle an incoming registration request.
    public function store(Request $request): RedirectResponse {
        Log::info('-----------------------------------');
        Log::info('RegisterUser Controller - register function');

        //  validate form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'auth' => 'required|integer|in:0,1,2,3,4',
        ]);        

        // create user in db
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'auth' => $request->auth,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
