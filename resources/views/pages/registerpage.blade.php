@extends('layouts.main-layout')
@section('content')
    @guest
    <h2>Registrazione</h2>
    <form action="{{ route('register') }}" method="POST">
        @method('POST')
        @csrf

        <label for="name">Name</label><br>
        <input type="text" name="name"><br>
        <label for="email">E-mail</label><br>
        <input type="text" name="email"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password"><br>
        <label for="password_confirmation">Password confirmation</label><br>
        <input type="password" name="password_confirmation"><br>
        <br>
        <button type="submit" class="btn btn-success">REGISTER</button>
    </form>

    <a class="btn btn-secondary" href="{{url('/')}}">BACK TO HOME</a>
    @endguest
@endsection