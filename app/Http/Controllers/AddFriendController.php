<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddFriendController extends Controller
{

    public function store(Request $request, $id)
    {
       \Auth::user()->add($id);
        return redirect()->back();
    }

   
}
