<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendsController extends Controller
{
    function index(){
        $userinst= new \App\User;
        $users = $userinst::all();
        
        return view('users.friends', [
            'friends' => $users,
        ]);
      
    }
    
    function show(Request $request){
        $friendId=$request->id;
        $userinst= new \App\User;
        $user = $userinst::find($friendId);
        
        
        return view('users.friend_detail', [
            'friend' => $user,
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
