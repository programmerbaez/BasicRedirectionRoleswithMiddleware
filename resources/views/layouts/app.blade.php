<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f5f6f8; }
        .navbar-brand { font-weight: 600; }
        .card { border: 0; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(auth()->user()->isAdmin())
                        @if(auth()->user()->hasPermission(\App\Permission::MANAGE_USERS))
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                        @endif
                        @if(auth()->user()->hasPermission(\App\Permission::CHANGE_PASSWORDS))
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.passwords.index') }}">Contraseñas</a></li>
                        @endif
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                @else
                    <li class="nav-item">
                        <span class="navbar-text mr-3">
                            {{ auth()->user()->name }}
                            <span class="badge badge-{{ auth()->user()->isAdmin() ? 'warning' : 'info' }}">
                                {{ auth()->user()->role->display_name }}
                            </span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="form-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @include('partials.alerts')
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
