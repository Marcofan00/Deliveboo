@extends('layouts.main-layout')
@section('content')
    @guest
    <div id="login1">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @method('POST')
            @csrf

            <label for="email">E-mail</label><br>
            <input type="text" name="email"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password"><br>
            <br>
            <button type="submit" class="btn btn-success">LOGIN</button>
        </form>
        <p>Se non sei registrato <a href="{{url('register')}}">Clicca qui</a></p>
        <a class="btn btn-secondary" href="{{url('/')}}">BACK TO HOME</a>
    </div>

    
    @endguest
@endsection