<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakegroupController extends Controller
{
        public function index()
    {
      $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $groups = $user->feed_groups()->orderBy('created_at', 'desc');

            $data = [
                'user' => $user,
                'groups' => $groups,
            ];
        }
        return view('welcome', $data);
    }
    
        public function store(Request $request)
    {
        // $this->validate($request, [
        //   'content' => 'required|max:191',
        // ]);

        $request->user()->groups()->create([
            'name' => $request->content,
        ]);

        return redirect()->back();
    }
    
        public function destroy($id)
    {
        $group = \App\Makegroup::find($id);

        if (\Auth::user()->id === $group->user_id) {
            $group->delete();
        }

        return redirect()->back();
    }
}

