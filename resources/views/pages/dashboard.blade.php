@extends('layouts.main-layout')
@section('content')
    <dashboard-component :logincheck="{{$check}}" :foods_user_check="{{$food_user}}"> </dashboard-component>
@endsection

{{-- :check="{{$check}}" --}}