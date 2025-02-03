<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    
    public function register(Request $request){
        // Validation
        $field = $request->validate([
            'name'=>['required', 'max:255'],
            'email'=>['required','email', 'max:255', 'unique:users'],
            'password'=>['required','confirmed']
        ]);
        // Register
        $user = User::create($field);

        //Login
        Auth::login($user);

        //Redirect
        return redirect()->route('home');

    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('home');    
    }
}
