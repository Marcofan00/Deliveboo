@extends('layouts.main-layout')
@section('content')
    {{-- {{ $foodEdit  }} --}}


    <edit-food-component :food_edit="{{$foodEdit}}"> </edit-food-component>
@endsection