@extends('layouts.main-layout')
@section('content')
    <dashboard-component :logincheck="{{$check}}"> </dashboard-component>
@endsection