<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // home - dashboard
    public function index()
    {
        return view('home.index');
    }


  
}   
