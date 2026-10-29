@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">Nuevo usuario</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    @include('admin.users._form')

                    <div class="form-group">
                        <label for="password">Contraseña inicial</label>
                        <input id="password" type="password" name="password" required
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                    </div>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancelar</a>
                    <button class="btn btn-success float-right">Crear usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
