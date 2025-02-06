<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    
    public function register(Request $request){
        // Validation
        $fields = $request->validate([
            'avatar'=>['file', 'nullable', 'max:3000'],
            'name'=>['required', 'max:255'],
            'email'=>['required','email', 'max:255', 'unique:users'],
            'password'=>['required','confirmed']
        ]);
        //Handle avatar
        if ($request->hasFile('avatar')){
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        // Register
        $user = User::create($fields);

        //Login
        Auth::login($user);

        //Redirect
        return redirect()->route('dashboard')->with('message','Welcome');

    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();
 
            return redirect()->route('dashboard')->with('message','Welcome back');
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

    public function delete(Request $request){
        // dd($request->id);
        if( Auth::user()->can('delete', User::class) ){
            User::destroy( $request->id );
        }
        return redirect()->route('home');
    }
}
