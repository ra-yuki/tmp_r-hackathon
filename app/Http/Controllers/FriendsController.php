<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendsController extends Controller
{
    function index(){
        $users =Group::All;
        
        return view('users.friends', [
            'users' => $users,
        ]);
      
    }
    
    function show(){
        return view('users.friends', [
            'users' => $users,
        ]);
    }
    
    public function store(Request $request, $id)
    {
        \Auth::user()->friend($id);
        return redirect()->back();
    }

    public function delete($id)
    {
        \Auth::user()->unfiend($id);
        return redirect()->back();
    }
    
}
