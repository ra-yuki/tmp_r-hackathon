@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $group->name }}</h3>
                </div>
                <div class="panel-body">
                    @include('users.friends', ['users' => $groups])
                </div>
            </div>
        </aside>
       
        </div>
    </div>
@endsection