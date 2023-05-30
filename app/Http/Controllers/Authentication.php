<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class Authentication extends Controller
{
    public function login()
    {
        if(Auth::user()) return redirect()->route('admin.dashboard');
        
        return view('login');
    }

    public function signin(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->onlyInput('email');
        }

        $user = User::whereEmail($request->email)->first();
        if(!$user)
        {
            return redirect()->back()->withErrors(['email'=>'No Email Registered'])->onlyInput('email');
        }

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return view('admin/dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
     
        return redirect('admin/login');
    }
}
