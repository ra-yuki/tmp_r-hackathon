<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupsController extends Controller
{
   
   public function show(){
       
   }
   
   public function store(Request $request, $id)
    {
        \Auth::user()->group($id);
        return redirect()->back();
    }

  
    
    public function delete()
    {
        $group = \App\Group::find($id);

        if (\Auth::user()->id === $group->user_id) {
            $group->delete();
        }

        return redirect()->back();
        
    }
}
