<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserResourceValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_admin_can_be_seeded(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@example.com')->first();

        $this->assertNotNull($admin);
        $this->assertSame('Demo Admin', $admin->name);
        $this->assertTrue(Hash::check('password', $admin->password));
        $this->assertGreaterThanOrEqual(6, User::query()->count());
    }

    public function test_user_password_is_hashed_via_model_cast(): void
    {
        $user = User::factory()->create([
            'password' => 'plain-secret-password',
        ]);

        $this->assertNotSame('plain-secret-password', $user->password);
        $this->assertTrue(Hash::check('plain-secret-password', $user->getAttributes()['password']));
    }
}
