<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class FriendsController extends Controller
{
    function index(){
        
        
        $users = \Auth::user()->friends()->paginate(1000);
        
        return view('users.friends', [
            'friends' => $users,
        ]);
      
    }
    
    function show($id){
        // $friendId=$request->id;
        // $userinst= new \App\User;
        // $user = $userinst::find($friendId);
        $user = User::find($id);
        
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
