@extends('layouts.app')

@section('title', 'Acceso denegado')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4">403</h1>
    <p class="lead">{{ $exception->getMessage() ?: 'No tienes acceso a esta página.' }}</p>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Volver a mi dashboard</a>
    @else
        <a href="{{ route('home') }}" class="btn btn-primary">Ir al inicio</a>
    @endauth
</div>
@endsection
