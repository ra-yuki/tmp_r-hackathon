@extends('layouts.app')

@section('content')
    <h1>Result</h1>
    <h2>available dates</h2>
    {{ dd($result) }}
@endsection