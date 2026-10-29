@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">Editar: {{ $user->name }}</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.users._form')

                    <p class="text-muted small">
                        La contraseña no se puede cambiar desde aquí; es una función exclusiva
                        del administrador con permiso para cambiar contraseñas.
                    </p>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancelar</a>
                    <button class="btn btn-primary float-right">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
