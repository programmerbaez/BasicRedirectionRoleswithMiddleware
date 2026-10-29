<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * CRUD de usuarios. Solo accesible con el permiso "manage_users".
 * La edición NO permite cambiar contraseñas: eso es exclusivo del
 * permiso "change_passwords" (Admin\PasswordController).
 */
class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'permissions')->orderBy('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('id')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            // Contraseña inicial obligatoria para poder crear la cuenta
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        $user->load('role', 'permissions');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('id')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // Un admin no puede quitarse su propio rol de administrador
        if ($user->id === auth()->id()) {
            unset($data['role_id']);
        }

        // Solo se actualizan estos campos: la contraseña nunca se toca aquí
        $user->update($data);

        // Si deja de ser admin, pierde sus permisos de administrador
        if (! $user->fresh()->isAdmin()) {
            $user->permissions()->detach();
        }

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Usuario eliminado correctamente.');
    }
}
