@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Nueva contraseña para {{ $user->name }}</h5>
                <small class="text-muted">{{ $user->email }} · {{ $user->role->display_name }}</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.passwords.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="password">Nueva contraseña</label>
                        <input id="password" type="password" name="password" required autofocus
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                    </div>

                    <a href="{{ route('admin.passwords.index') }}" class="btn btn-link">Cancelar</a>
                    <button class="btn btn-primary float-right">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
