<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Pages\Auth\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentAdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_reachable(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_demo_admin_can_authenticate_to_filament_panel(): void
    {
        $this->seed();

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'admin@example.com',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs(User::query()->where('email', 'admin@example.com')->first());
    }

    public function test_authenticated_user_can_open_users_resource(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk();
    }
}
