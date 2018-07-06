@extends('layouts.app')

@section('cover')
@endsection

@section('content')

<div class="container-fluid">
<div class="row">
 
<!--↓↓ 検索フォーム ↓↓-->
<div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
<form class="form-inline" action="{{route('user.index')}}">
  <div class="form-group">
  <input type="text" name="userId" value="{{$userId}}" class="form-control" placeholder="Search New Friends">
  </div>
  <input type="submit" value="Search" class="btn btn-info">
</form>
</div>
<!--↑↑ 検索フォーム ↑↑-->
 

@if (count($SearchResult) > 0)
<ul class="media-list">
@foreach ($SearchResult as $item)
    <li class="media">
       
        <div class="media-body">
            <div>
                {{ $item->name }}
            </div>
            <div>
                {{-- <p>{!! link_to_route('users.show', 'View profile', ['id' => $user->id]) !!}</p> --}}
            </div>
        </div>
    </li>
@endforeach
</ul>

@endif




@endsection