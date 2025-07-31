<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Đăng nhập user mặc định cho mọi test với Sanctum
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_can_get_users_list()
    {
        // Arrange - Tạo thêm users để test
        $users = User::factory(5)->create();

        // Act
        $response = $this->getJson('/api/v1/users');

        // Assert
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'role',
                            'status',
                            'avatar_url',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'meta' => [
                        'current_page',
                        'per_page',
                        'total',
                        'last_page'
                    ]
                ]);

        // Có 6 users (1 từ setUp + 5 từ factory)
        $this->assertEquals(6, $response->json('meta.total'));
    }

    public function test_can_get_users_with_pagination()
    {
        // Arrange
        User::factory(15)->create();

        // Act
        $response = $this->getJson('/api/v1/users?per_page=5&page=2');

        // Assert
        $response->assertStatus(200);
        $this->assertEquals(16, $response->json('meta.total')); // 1 từ setUp + 15 từ factory
        $this->assertEquals(5, $response->json('meta.per_page'));
        $this->assertEquals(2, $response->json('meta.current_page'));
        $this->assertEquals(4, $response->json('meta.last_page')); // 16 users / 5 per page = 4 pages
    }

    public function test_can_search_users_by_name()
    {
        // Arrange - Xóa users cũ và tạo users mới với tên cụ thể
        User::where('id', '!=', auth()->id())->delete();
        User::factory(3)->create(['name' => 'John Doe']);
        User::factory(2)->create(['name' => 'Jane Smith']);

        // Act
        $response = $this->getJson('/api/v1/users?search=John');

        // Assert
        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('meta.total'));
        
        $users = $response->json('data');
        foreach ($users as $user) {
            $this->assertStringContainsString('John', $user['name']);
        }
    }

    public function test_can_filter_users_by_role()
    {
        // Arrange - Xóa users cũ và tạo users mới với role cụ thể
        User::where('id', '!=', auth()->id())->delete();
        User::factory(3)->create(['role' => 'admin']);
        User::factory(2)->create(['role' => 'user']);

        // Act
        $response = $this->getJson('/api/v1/users?role=admin');

        // Assert
        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('meta.total'));
        
        $users = $response->json('data');
        foreach ($users as $user) {
            $this->assertEquals('admin', $user['role']);
        }
    }

    public function test_can_search_and_filter_users()
    {
        // Arrange - Xóa users cũ và tạo users mới với tên và role cụ thể
        User::where('id', '!=', auth()->id())->delete();
        User::factory(2)->create([
            'name' => 'John Admin',
            'role' => 'admin'
        ]);
        User::factory(1)->create([
            'name' => 'John User',
            'role' => 'user'
        ]);
        User::factory(3)->create([
            'name' => 'Jane Admin',
            'role' => 'admin'
        ]);

        // Act
        $response = $this->getJson('/api/v1/users?search=John&role=admin');

        // Assert
        $response->assertStatus(200);
        $this->assertEquals(2, $response->json('meta.total'));
        
        $users = $response->json('data');
        foreach ($users as $user) {
            $this->assertStringContainsString('John', $user['name']);
            $this->assertEquals('admin', $user['role']);
        }
    }

    public function test_returns_empty_list_when_no_users()
    {
        // Arrange - Xóa tất cả users trừ user đang đăng nhập
        User::where('id', '!=', auth()->id())->delete();

        // Act
        $response = $this->getJson('/api/v1/users');

        // Assert
        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('meta.total')); // Chỉ còn user đang đăng nhập
        $this->assertCount(1, $response->json('data'));
    }

    public function test_returns_correct_user_data_structure()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'manager',
            'status' => 'active'
        ]);

        // Act
        $response = $this->getJson('/api/v1/users');

        // Assert
        $response->assertStatus(200);
        
        $users = $response->json('data');
        $userData = collect($users)->firstWhere('id', $user->id);
        
        $this->assertNotNull($userData);
        $this->assertEquals('Test User', $userData['name']);
        $this->assertEquals('test@example.com', $userData['email']);
        $this->assertEquals('manager', $userData['role']);
        $this->assertEquals('active', $userData['status']);
        $this->assertArrayHasKey('avatar_url', $userData);
        $this->assertArrayHasKey('created_at', $userData);
        $this->assertArrayHasKey('updated_at', $userData);
    }

    public function test_handles_invalid_pagination_parameters()
    {
        // Arrange
        User::factory(5)->create();

        // Act
        $response = $this->getJson('/api/v1/users?per_page=invalid&page=invalid');

        // Assert
        $response->assertStatus(200); // Should still work with default values
        $this->assertEquals(6, $response->json('meta.total')); // 1 từ setUp + 5 từ factory
    }

    public function test_handles_large_page_number()
    {
        // Arrange
        User::factory(5)->create();

        // Act
        $response = $this->getJson('/api/v1/users?page=999');

        // Assert
        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
        // Laravel pagination sẽ trả về page cuối cùng thay vì page 1
        $this->assertGreaterThan(1, $response->json('meta.current_page'));
    }
} 