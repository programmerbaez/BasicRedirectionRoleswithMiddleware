<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const USER = 'user';
    const ADMIN = 'admin';

    protected $fillable = ['name', 'display_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
