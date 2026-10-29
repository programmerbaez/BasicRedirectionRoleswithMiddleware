@extends('layouts.app')

@section('title', 'Mi dashboard')

@section('content')
<h2 class="mb-4">Dashboard de usuario</h2>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Hola, {{ auth()->user()->name }} 👋</h5>
        <p class="card-text mb-1"><strong>Correo:</strong> {{ auth()->user()->email }}</p>
        <p class="card-text mb-1"><strong>Rol:</strong> {{ auth()->user()->role->display_name }}</p>
        <p class="card-text"><strong>Miembro desde:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</p>
        <p class="text-muted mb-0">Esta área solo es visible para usuarios con rol <code>user</code>.</p>
    </div>
</div>
@endsection
