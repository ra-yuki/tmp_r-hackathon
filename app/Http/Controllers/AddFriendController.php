<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddFriendController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->friend($id);
        return redirect()->back();
 
    }

   
}
