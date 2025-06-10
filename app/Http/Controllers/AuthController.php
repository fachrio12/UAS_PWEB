<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $username = Auth::user()->name;

            if (Auth::user()->role_id == 1) { 
                return redirect()->route('admin.dashboard', ['username' => $username]);
            } else {
                return redirect()->route('user.assessments');
            }
        }
        
        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan tidak valid.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'birth_date' => 'required|date',
            'gender'     => 'required',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'birth_date'    => $request->birth_date,
            'gender'        => $request->gender,
            'role_id'       => 2, 
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}