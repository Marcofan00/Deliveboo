@extends('layouts.main-layout')
@section('content')
    <create-food-component :userid="{{Auth::User() -> id}}"> </create-food-component>
@endsection