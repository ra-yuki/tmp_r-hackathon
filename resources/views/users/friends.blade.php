@extends('layouts.app')

@section('content')


{{-- display friends and groups --}}
<div class="container">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#group">Groups</a></li>
    <li><a data-toggle="tab" href="#friend">Friends</a></li>
  </ul>

  <div class="tab-content">
      <div id="group" class="tab-pane fade in active">
    <h3>Groups</h3>
      <?php $groups = \Auth::user()->groups; ?>
      @foreach ($groups as $group)
           <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div>
                        {!! link_to_route('groups.show',$group->name, ['id' => $group->id]) !!}<p>{!! nl2br(e($group->name)) !!}</p>{{ $group->created_at }}
                    </div>
                    
            
                </div>
            </div>
    
@endforeach
    
   
        
    </div>
     <div id="friend" class="tab-pane fade ">
      <h3>Friends</h3>
      {{-- ↓↓ 検索フォーム ↓↓ --}}

<form class="form-inline" action="{{route('friends.index')}}">
  <div class="form-group">
  <input type="text" name="friendId" value="{{$friendId}}" class="form-control" placeholder="Search Friends">
  </div>
  <input type="submit" value="Search" class="bt">
</form>

{{-- ↑↑ 検索フォーム ↑↑ --}}
        @foreach ($friends as $friend)
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div>{!! link_to_route('friends.show',$friend->name, ['id' => $friend->id]) !!}<p>{!! nl2br(e($friend->name)) !!}</p>{{ $friend->created_at }}</div>
            </div>
        </div>
        @endforeach
    </div>
  </div>
</div>

@endsection