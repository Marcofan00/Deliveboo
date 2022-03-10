@extends('layouts.main-layout')
@section('content')
    <order-info-component :ordine="{{$foods}}" :ordinecheck="{{$ordineinfo}}"> </order-info-component>
@endsection