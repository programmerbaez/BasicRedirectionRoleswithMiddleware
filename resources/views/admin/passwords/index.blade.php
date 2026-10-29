@extends('layouts.app')

@section('title', 'Cambiar contraseñas')

@section('content')
<h2 class="mb-3">Cambiar contraseñas</h2>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr><th>#</th><th>Nombre</th><th>Correo</th><th>Rol</th><th class="text-right">Acción</th></tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-{{ $user->isAdmin() ? 'warning' : 'info' }}">{{ $user->role->display_name }}</span></td>
                    <td class="text-right">
                        <a href="{{ route('admin.passwords.edit', $user) }}" class="btn btn-sm btn-outline-primary">Cambiar contraseña</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
