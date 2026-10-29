@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Usuarios</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">+ Nuevo usuario</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Permisos</th><th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->isAdmin() ? 'warning' : 'info' }}">{{ $user->role->display_name }}</span>
                    </td>
                    <td class="small">
                        {{ $user->permissions->pluck('display_name')->implode(', ') ?: '—' }}
                    </td>
                    <td class="text-right text-nowrap">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No hay usuarios.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
