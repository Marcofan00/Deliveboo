@extends('layouts.main-layout')
@section('content')
   <success-component :order="{{ $order }}"></success-component>
@endsection