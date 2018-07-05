<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendsController extends Controller
{
 function index(){
        return view('users.friends');
        // return redirect()->back();
    }
    
    function show(){
        // return view('users.friends');
    }
    
    function store(){
        return view('welcome');
    }
    
    function delete(){
        return view('welcome');
    }
}
