<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // roles, permisos, admin1, admin2, user
    }

    private function u($email)
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function test_home_es_publica()
    {
        $this->get('/')->assertOk();
    }

    public function test_invitado_no_entra_a_dashboards()
    {
        $this->get('/user/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_login_redirige_segun_rol()
    {
        $this->post('/login', ['email' => 'user@example.com', 'password' => 'password'])
            ->assertRedirect(route('user.dashboard'));
        $this->post('/logout');

        $this->post('/login', ['email' => 'admin1@example.com', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_registro_crea_rol_user()
    {
        $this->post('/register', [
            'name' => 'Nuevo', 'email' => 'nuevo@example.com',
            'password' => 'secret123', 'password_confirmation' => 'secret123',
        ])->assertRedirect(route('user.dashboard'));

        $this->assertTrue($this->u('nuevo@example.com')->hasRole('user'));
    }

    public function test_roles_no_cruzan_rutas()
    {
        $this->actingAs($this->u('user@example.com'))->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($this->u('admin1@example.com'))->get('/user/dashboard')->assertForbidden();
    }

    public function test_admin1_solo_crud()
    {
        $admin1 = $this->u('admin1@example.com');

        $this->actingAs($admin1)->get('/admin/users')->assertOk();
        $this->actingAs($admin1)->get('/admin/passwords')->assertForbidden();
    }

    public function test_admin2_solo_contrasenas()
    {
        $admin2 = $this->u('admin2@example.com');
        $user = $this->u('user@example.com');

        $this->actingAs($admin2)->get('/admin/users')->assertForbidden();
        $this->actingAs($admin2)->delete("/admin/users/{$user->id}")->assertForbidden();

        $this->actingAs($admin2)->put("/admin/passwords/{$user->id}", [
            'password' => 'nueva1234', 'password_confirmation' => 'nueva1234',
        ])->assertRedirect(route('admin.passwords.index'));

        $this->assertTrue(Hash::check('nueva1234', $user->fresh()->password));
    }

    public function test_user_no_accede_a_funciones_admin()
    {
        $user = $this->u('user@example.com');

        $this->actingAs($user)->get('/admin/users')->assertForbidden();
        $this->actingAs($user)->get('/admin/passwords')->assertForbidden();
    }
}
