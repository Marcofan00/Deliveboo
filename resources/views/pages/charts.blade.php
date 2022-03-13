@extends('layouts.main-layout')
@section('content')
    <line-chart-component :user={{ $userId }}></line-chart-component>
@endsection