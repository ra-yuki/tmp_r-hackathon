@extends('layouts.app')

@section('cover')
@endsection

@section('content')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">

                  
                <div class="img">
                <img src={{ secure_asset('images/pp.gif') }}>
                </div>
                
                
                <a href="{{ route('signup.get') }}" class="bt"><div id="a">Sign Up</div></a>
                
                <a href="{{ route('login') }}" class="bt"><div id="a">Log In</div></a>
                
            </div>
        </div>
    </div>
  
@endsection