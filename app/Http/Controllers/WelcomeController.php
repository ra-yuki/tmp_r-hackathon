<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
  
    function index(){
        if (\Auth::check())
            return view('users.index');
        
        else 
            return view('welcome');
    }
}
