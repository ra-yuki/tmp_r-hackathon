{!! Form::open(['route' => ['add.get', $user->id], 'method' => 'get']) !!}
    {!! Form::submit('Add', ['class' => "btn btn-danger btn-xs"]) !!}
{!! Form::close() !!}
