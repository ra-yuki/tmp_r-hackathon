@if (Auth::id() != $user->id)
    @if (Auth::user()->is_friending($user->id))

    {!! Form::open(['route' => ['unfriend', $user->id], 'method' => 'delete']) !!}
        {!! Form::submit('Unfriend', ['class' => "btn btn-danger btn-block"]) !!}
    {!! Form::close() !!}
 
 @else
 
    {!! Form::open(['route' => ['add.get', $user->name], 'method' => 'get']) !!}
        {!! Form::submit('Add', ['class' => "btn btn-danger btn-xs"]) !!}
    {!! Form::close() !!}
   
    @endif
@endif