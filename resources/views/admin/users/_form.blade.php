{{-- Campos compartidos entre crear y editar --}}
<div class="form-group">
    <label for="name">Nombre</label>
    <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
           class="form-control @error('name') is-invalid @enderror">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="email">Correo electrónico</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
           class="form-control @error('email') is-invalid @enderror">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="role_id">Rol</label>
    @php($editingSelf = isset($user) && $user->id === auth()->id())
    <select id="role_id" name="role_id" class="form-control @error('role_id') is-invalid @enderror"
            {{ $editingSelf ? 'disabled' : '' }}>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ (string) old('role_id', $user->role_id ?? '') === (string) $role->id ? 'selected' : '' }}>
                {{ $role->display_name }}
            </option>
        @endforeach
    </select>
    @if($editingSelf)
        {{-- Un select deshabilitado no se envía; mandamos el valor actual --}}
        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
        <small class="form-text text-muted">No puedes cambiar tu propio rol.</small>
    @endif
    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
