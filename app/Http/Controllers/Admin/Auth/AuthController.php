<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\ScUsuarios;


class AuthController extends Controller
{
	public function __construct()
    {
    }
    
	public function index()
    {
        return view('login.index');
    }
	
    public function authenticate(Request $request)
    {
        $credentials = $request->only('login','password');
		if(Auth::guard('web')->attempt($credentials)){
           return redirect()->route('home');
        }else{
            return redirect()->back()->with('message','Credenciais incorretas');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('login');
    }
}
