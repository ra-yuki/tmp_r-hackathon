@extends('layouts.app')

@section('cover')
@endsection

@section('content')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">

 <h1 class="ml1">
    <span class="text-wrapper">
    <span class="line line1"></span>
    <span class="letters">CALENDAR</span>
    <span class="line line2"></span>
    </span>
</h1>
               <p class="p">Everyone's schedules on one calender</p>
                

                <a href="{{ route('signup.get') }}" id="a">Sign up</a>
                
                <a href="{{ route('login') }}" id="b">Log In</a>
                
                <a href="{{ route('friends') }}" id="b">Friends</a>
                

  
               
            </div>
            
        </div>
        <a href="/" id="what">What is CALENDER?</a>
        
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="{{ secure_asset('js/test.js') }}"></script>     
@endsection