@extends('layouts.app')



@section('content')
@include('group.makegroup_button')
    <div class="user-profile">
        
        <div class="name text-center">
            <img src={{ secure_asset('images/ariel.png') }}>
          <img src={{ secure_asset('images/calender.png') }}>
           
        </div>
        <div class="status text-center">
            
    
        </div>
        
          
 
        
    </div>
 
@endsection