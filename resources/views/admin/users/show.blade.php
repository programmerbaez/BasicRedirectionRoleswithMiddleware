@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">{{ $user->name }}</h5></div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                <li class="list-group-item"><strong>Correo:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Rol:</strong> {{ $user->role->display_name }}</li>
                <li class="list-group-item"><strong>Permisos:</strong>
                    {{ $user->permissions->pluck('display_name')->implode(', ') ?: 'Ninguno' }}
                </li>
                <li class="list-group-item"><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
            </ul>
            <div class="card-body">
                <a href="{{ route('admin.users.index') }}" class="btn btn-link">Volver</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary float-right">Editar</a>
            </div>
        </div>
    </div>
</div>
@endsection
