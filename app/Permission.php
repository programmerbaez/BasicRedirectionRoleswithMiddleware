<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    const MANAGE_USERS = 'manage_users';         // CRUD de usuarios
    const CHANGE_PASSWORDS = 'change_passwords'; // Cambiar contraseñas

    protected $fillable = ['name', 'display_name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
