# Laravel 6 · Roles y permisos

Proyecto base en **Laravel 6** con página de inicio pública, login/registro, dos roles (`user`, `admin`) y permisos guardados en la base de datos.

## Requisitos

- PHP **7.2.5 – 8.0** (Laravel 6 no soporta oficialmente PHP 8.1+; recomendado 7.4 u 8.0)
- Composer
- Extensión `pdo_sqlite` (o MySQL / MariaDB)

## Instalación (SQLite, lista para usar)

La base de datos ya viene creada en `database/database.sqlite`, con las tablas migradas
y los usuarios de prueba cargados. El archivo `.env` ya está configurado para SQLite.

```bash
composer install
php artisan serve
```

Abre http://127.0.0.1:8000

Requiere la extensión `pdo_sqlite` de PHP (en `php.ini`: `extension=pdo_sqlite`).

**Reiniciar la base de datos desde cero:**

```bash
php artisan migrate:fresh --seed
```

Si se borró el archivo, créalo vacío antes (`touch database/database.sqlite`, o en
Windows `type nul > database\database.sqlite`) y ejecuta el comando anterior.

> Si usas git, `database/.gitignore` excluye `*.sqlite`: el archivo de la BD no se sube al repositorio.

### Usar MySQL en lugar de SQLite

En `.env`, cambia `DB_CONNECTION=sqlite` por la configuración de MySQL que está comentada justo debajo,
crea la base `laravel6_roles` y ejecuta `php artisan migrate --seed`.

> No necesitas `npm`: las vistas usan Bootstrap 4 por CDN.

## Usuarios de prueba (contraseña: `password`)

| Correo               | Rol   | Permiso                          | Qué puede hacer                                    |
|----------------------|-------|----------------------------------|----------------------------------------------------|
| admin1@example.com   | admin | `manage_users`                   | CRUD de usuarios (sin cambiar contraseñas)         |
| admin2@example.com   | admin | `change_passwords`               | Cambiar contraseña de users y admins (sin CRUD)    |
| user@example.com     | user  | —                                | Solo su dashboard                                  |

Todo usuario que se registra desde `/register` queda con rol **user**.

## Estructura de la base de datos

```
roles            id, name (user|admin), display_name
users            id, role_id → roles.id, name, email, password, ...
permissions      id, name (manage_users|change_passwords), display_name
permission_user  permission_id → permissions.id, user_id → users.id
```

Los permisos se asignan **por usuario** (no por rol), así dos administradores pueden tener capacidades distintas.

## Rutas y protección

| Ruta                          | Middleware                                   |
|-------------------------------|----------------------------------------------|
| `/`                           | pública                                      |
| `/login`, `/register`         | `guest` (si ya hay sesión → su dashboard)    |
| `/dashboard`                  | `auth` → redirige al dashboard de su rol     |
| `/user/dashboard`             | `auth` + `role:user`                         |
| `/admin/dashboard`            | `auth` + `role:admin`                        |
| `/admin/users/*` (resource)   | `auth` + `role:admin` + `permission:manage_users`     |
| `/admin/passwords/*`          | `auth` + `role:admin` + `permission:change_passwords` |

- Sin sesión → redirección a `/login`.
- Rol o permiso incorrecto → página **403**.
- Tras login/registro, cada rol va a su propio dashboard.

## Archivos clave

```
app/Role.php, app/Permission.php, app/User.php        Modelos y helpers (hasRole, hasPermission, dashboardRoute)
app/Http/Middleware/CheckRole.php                     middleware 'role'
app/Http/Middleware/CheckPermission.php               middleware 'permission'
app/Http/Middleware/RedirectIfAuthenticated.php       'guest' redirige según rol
app/Http/Controllers/Auth/*                           login / registro con redirección por rol
app/Http/Controllers/Admin/UserController.php         CRUD (admin 1)
app/Http/Controllers/Admin/PasswordController.php     cambio de contraseñas (admin 2)
routes/web.php                                        rutas agrupadas por rol y permiso
database/seeds/DatabaseSeeder.php                     roles, permisos y usuarios de prueba
tests/Feature/RoleAccessTest.php                      pruebas de acceso
```

## Pruebas

```bash
vendor/bin/phpunit
```

(usa SQLite en memoria; requiere la extensión `pdo_sqlite`).

## Asignar permisos a otro admin

El CRUD no asigna permisos a propósito (si no, el admin 1 podría darse a sí mismo o a otro el permiso del admin 2). Para asignarlos:

```bash
php artisan tinker
>>> $u = App\User::where('email', 'otro@example.com')->first();
>>> $u->permissions()->attach(App\Permission::where('name', 'change_passwords')->first());
```
# BasicRedirectionRoleswithMiddleware
