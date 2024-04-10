<?php

namespace Modules\Api\Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\JWTAuth;

class AuthLoginTest extends TestCase
{
    /**
     * @return void
     */
    public function testValidRequestShouldReturnBadRequest(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'nam']);

        $response->assertStatus(422);
    }

    public function testValidRequestShouldReturnSuccess(): void
    {
        $user = User::factory()->state(['password' => Hash::make('12345678')])->create();

        $response = $this->postJson('/api/login', ['email' => $user->email, 'password' => '12345678']);
        $response->assertStatus(200);
    }

    public function testValidTokenShouldReturnSuccess(): void
    {
        $jwtAuth = app(JWTAuth::class);
        $user = User::factory()->state(['password' => Hash::make('12345678')])->create();
        $token = $jwtAuth->fromUser($user);

        $response = $this->getJson('/api/test-auth', ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    public function testInvalidTokenShouldReturnSuccess(): void
    {
        User::factory()->state(['password' => Hash::make('12345678')])->create();
        $response = $this->getJson('/api/test-auth', ['Authorization' => 'Bearer asdasdasdasd']);

        $response->assertStatus(401);
    }
}
