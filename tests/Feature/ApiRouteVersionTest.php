<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ApiRouteVersionTest extends TestCase
{
    public function test_api_v1_fetch_user_and_should_return_ok()
    {
        $user = User::factory()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'jdc@test.com',
            'email_verified_at' => null,
        ]);

        $this
            ->actingAs($user, 'sanctum')
            ->getJson('/api/v1/user')
            ->assertOk();
    }
}
