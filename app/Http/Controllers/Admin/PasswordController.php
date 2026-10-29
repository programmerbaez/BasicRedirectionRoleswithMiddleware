<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Cambio de contraseñas de usuarios y administradores.
 * Solo accesible con el permiso "change_passwords".
 * No permite crear, editar datos ni eliminar usuarios.
 */
class PasswordController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('id')->paginate(10);

        return view('admin.passwords.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.passwords.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->setRememberToken(null); // invalida sesiones "recordarme"
        $user->save();

        return redirect()->route('admin.passwords.index')
            ->with('status', "Contraseña de {$user->name} actualizada correctamente.");
    }
}
