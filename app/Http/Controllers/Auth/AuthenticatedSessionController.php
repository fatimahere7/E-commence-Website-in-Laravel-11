<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        
        ]);

        // Attempt to log in the user
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'seller') {
                return redirect()->route('welcomeHome');
            }
            
            return redirect()->route('welcomeHome'); // Adjust to your user's home route
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    // public function authenticated(Request $request, $user)
    // {
    //     return redirect()->intended('/cart'); // Redirect to the cart or the intended URL
    // }
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('welcomeHome');
    }
}

