@extends('layouts.main-layout')
@section('content')
    @guest

        <login-component></login-component>
    
    @endguest
@endsection