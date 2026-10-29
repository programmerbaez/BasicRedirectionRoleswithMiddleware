@extends('layouts.app')

@section('title', 'Panel de administración')

@section('content')
@php($me = auth()->user())

<h2 class="mb-4">Dashboard de administrador</h2>

<div class="row mb-4">
    <div class="col-sm-6 mb-3">
        <div class="card"><div class="card-body">
            <div class="text-muted small">Usuarios</div>
            <div class="h3 mb-0">{{ $stats['users'] }}</div>
        </div></div>
    </div>
    <div class="col-sm-6 mb-3">
        <div class="card"><div class="card-body">
            <div class="text-muted small">Administradores</div>
            <div class="h3 mb-0">{{ $stats['admins'] }}</div>
        </div></div>
    </div>
</div>

<h5 class="mb-3">Tus permisos</h5>
<div class="row">
    @if($me->hasPermission(\App\Permission::MANAGE_USERS))
        <div class="col-md-6 mb-3">
            <div class="card h-100"><div class="card-body">
                <h5 class="card-title">Administrar usuarios</h5>
                <p class="card-text">Crear, ver, editar y eliminar usuarios.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Ir al CRUD</a>
            </div></div>
        </div>
    @endif

    @if($me->hasPermission(\App\Permission::CHANGE_PASSWORDS))
        <div class="col-md-6 mb-3">
            <div class="card h-100"><div class="card-body">
                <h5 class="card-title">Cambiar contraseñas</h5>
                <p class="card-text">Cambiar la contraseña de usuarios y administradores.</p>
                <a href="{{ route('admin.passwords.index') }}" class="btn btn-primary">Gestionar contraseñas</a>
            </div></div>
        </div>
    @endif

    @if($me->permissions->isEmpty())
        <div class="col-12">
            <div class="alert alert-secondary">No tienes permisos asignados todavía.</div>
        </div>
    @endif
</div>
@endsection
