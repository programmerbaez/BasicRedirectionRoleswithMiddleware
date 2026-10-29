<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Después de iniciar sesión, cada rol va a su propio dashboard.
     */
    protected function redirectTo()
    {
        return auth()->user()->dashboardRoute();
    }
}
