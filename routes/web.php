<?php

use App\Permission;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')->name('home');

// Login, register y logout (laravel/ui). Sin reset de contraseña ni verificación.
Auth::routes(['reset' => false, 'verify' => false, 'confirm' => false]);

/*
|--------------------------------------------------------------------------
| Rutas protegidas: requieren sesión iniciada
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Redirige al dashboard que corresponda según el rol
    Route::get('/dashboard', function () {
        return redirect(auth()->user()->dashboardRoute());
    })->name('dashboard');

    // ---------------- Rol: user ----------------
    Route::prefix('user')->name('user.')->middleware('role:user')->namespace('User')->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    });

    // ---------------- Rol: admin ----------------
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->namespace('Admin')->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        // Permiso: administrar usuarios (CRUD) -> Admin 1
        Route::middleware('permission:' . Permission::MANAGE_USERS)->group(function () {
            Route::resource('users', 'UserController');
        });

        // Permiso: cambiar contraseñas -> Admin 2
        Route::middleware('permission:' . Permission::CHANGE_PASSWORDS)->group(function () {
            Route::get('passwords', 'PasswordController@index')->name('passwords.index');
            Route::get('passwords/{user}/edit', 'PasswordController@edit')->name('passwords.edit');
            Route::put('passwords/{user}', 'PasswordController@update')->name('passwords.update');
        });
    });
});
