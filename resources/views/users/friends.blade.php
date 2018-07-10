@extends('layouts.app')

{{-- ↓↓ 検索フォーム ↓↓ --}}

<form class="form-inline" action="{{route('friends.index')}}">
  <div class="form-group">
  <input type="text" name="friendId" value="{{$friendId}}" class="form-control" placeholder="Search Friends">
  </div>
  <input type="submit" value="Search" class="bt">
</form>

{{-- ↑↑ 検索フォーム ↑↑ --}}

 
<ul class="media-list">
@foreach ($friends as $friend)
    <?php $user = $friend->user; ?>
    
           <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="panel panel-default">
                    <div>
                        {!! link_to_route('friends.show',$friend->name, ['id' => $friend->id]) !!}<p>{!! nl2br(e($friend->name)) !!}</p>{{ $friend->created_at }}
                    </div>
                    <div>
                        @if (Auth::user()->id == $friend->user_id)
                             
                            {!! Form::open(['route' => ['friends.destroy', $friend->id], 'method' => 'delete']) !!}
                                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-xs']) !!}
                            {!! Form::close() !!}
                          
                        @endif
                    </div>
            
                </div>
            </div>
    
@endforeach