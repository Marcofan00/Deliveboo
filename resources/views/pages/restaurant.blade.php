@extends('layouts.main-layout')
@section('content')
   <restaurant-component :restaurant="{{ $userId }}"></restaurant-component>
@endsection