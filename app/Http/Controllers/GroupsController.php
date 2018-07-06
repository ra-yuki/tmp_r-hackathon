<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupsController extends Controller
{
   
   function index(){
        $users =Group::All;
        
        return view('group.group', [
            'groups' => $groups,
        ]);
      
    }
    
    function show(){
        return view('group.group_detail', [
            'groups' => $groups,
        ]);
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
