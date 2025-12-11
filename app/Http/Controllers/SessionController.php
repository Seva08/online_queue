<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth; 

class SessionController extends Controller
{
    function index()
    {
        return view('login');
    }
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'password.required' => 'Password is required'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($infologin)){
            if(Auth::user()->role == 'user'){
                return redirect('admin/user');
            } else {
                return redirect('admin');
            }
        }else{
            return redirect('')->withErrors(['loginError' => 'Invalid email or password'])->withInput();
        }

       
    }
    function logout()
       {
           Auth::logout();
           return redirect('');
       }
}
