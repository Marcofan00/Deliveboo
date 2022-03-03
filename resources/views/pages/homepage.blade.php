@extends('layouts.main-layout')
@section('content')
    <div id="layout">
        <img id="layout_style_1" src="{{asset('storage/img/Vector.svg')}}" alt="vettore1">
        <img id="layout_style_2" src="{{asset('storage/img/vectoruno.png')}}" alt="vettore2">
        <homepage-component></homepage-component>
    </div>
@endsection