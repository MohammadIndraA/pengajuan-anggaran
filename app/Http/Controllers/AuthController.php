<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;  

class AuthController extends Controller
{

    public function login(){
        return view('auth.login.index');
    }
    public function postLogin(Request $request)  
    {  
        $request->validate([  
            'email' => 'required|email',  
            'password' => 'required',  
        ]);  
    
        $credentials = $request->only('email', 'password');  
    
        if (Auth::attempt($credentials)) {  
            if (Auth::user()->role === "regency") {
                return redirect()->intended('/pengajuan-anggaran');  
            }else {
                return redirect()->intended('/dashboard');  
            }
        }  
    
        throw ValidationException::withMessages([  
            'email' => 'Email atau Password salah.', // More specific error message  
        ]);  
    }  

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
