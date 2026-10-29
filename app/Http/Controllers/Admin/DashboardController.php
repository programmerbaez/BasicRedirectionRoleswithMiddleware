<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::whereHas('role', function ($q) {
                $q->where('name', Role::USER);
            })->count(),
            'admins' => User::whereHas('role', function ($q) {
                $q->where('name', Role::ADMIN);
            })->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
