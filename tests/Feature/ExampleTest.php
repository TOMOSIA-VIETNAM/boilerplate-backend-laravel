<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Authenticate user
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
    }
}
