@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="jumbotron bg-white">
    <h1 class="display-5">Bienvenido a {{ config('app.name') }}</h1>
    <p class="lead">Proyecto base en Laravel 6 con autenticación, roles (<code>user</code> y <code>admin</code>) y permisos guardados en la base de datos.</p>
    <hr class="my-4">

    @guest
        <p>Inicia sesión o crea una cuenta para entrar a tu panel.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Iniciar sesión</a>
        <a class="btn btn-outline-secondary btn-lg" href="{{ route('register') }}">Registrarse</a>
    @else
        <p>Ya iniciaste sesión como <strong>{{ auth()->user()->name }}</strong>.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('dashboard') }}">Ir a mi dashboard</a>
    @endguest
</div>
@endsection
