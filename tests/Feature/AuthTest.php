<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_successful_login()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'email_verified_at' => null
        ]);

        $this->postJson(route('auth.login'), [
                'email' => $user->email,
                'password' => 'password'
            ])
            ->assertSee('Successfully logged in')
            ->assertJsonStructure([
                'message',
                'token'
            ]);
    }
}
