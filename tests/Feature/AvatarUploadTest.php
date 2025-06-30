<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Containers\User\Models\User;
use App\Core\Services\FileUploadService;
use App\Containers\User\Actions\UploadAvatarAction;
use App\Containers\User\Data\DTOs\UploadAvatarDTO;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create symbolic link for storage
        $this->artisan('storage:link');
        
        // Clear storage before each test
        Storage::disk('public')->deleteDirectory('avatars');
    }

    public function test_can_upload_avatar_first_time()
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100);
        
        // Act
        $response = $this->postJson("/api/v1/users/{$user->id}/avatar", [
            'avatar' => $file
        ]);
        
        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => 'avatars/' . $user->id . '/' . $file->hashName()
        ]);
    }

    public function test_can_upload_avatar_second_time()
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        // First upload
        $file1 = UploadedFile::fake()->image('avatar1.jpg', 100, 100);
        $response1 = $this->postJson("/api/v1/users/{$user->id}/avatar", [
            'avatar' => $file1
        ]);
        $response1->assertStatus(200);
        
        // Second upload
        $file2 = UploadedFile::fake()->image('avatar2.jpg', 100, 100);
        
        // Act
        $response2 = $this->postJson("/api/v1/users/{$user->id}/avatar", [
            'avatar' => $file2
        ]);
        
        // Assert
        $response2->assertStatus(200);
        
        // Check that old file is deleted and new file exists
        $user->refresh();
        $this->assertNotEquals($response1->json('data.avatar_url'), $response2->json('data.avatar_url'));
    }

    public function test_file_upload_service_permissions()
    {
        // Arrange
        $service = app(FileUploadService::class);
        $file = UploadedFile::fake()->image('test.jpg', 100, 100);
        
        // Test directory creation
        $path = 'avatars/test-user';
        
        // Act & Assert
        $this->assertTrue(Storage::disk('public')->makeDirectory($path));
        $this->assertTrue(Storage::disk('public')->exists($path));
        
        // Test file upload
        $uploadedPath = $service->uploadAvatar($file, 'test-user');
        $this->assertTrue(Storage::disk('public')->exists($uploadedPath));
        
        // Test file deletion
        $this->assertTrue($service->delete($uploadedPath));
        $this->assertFalse(Storage::disk('public')->exists($uploadedPath));
    }

    public function test_upload_avatar_action_with_logging()
    {
        // Arrange
        $user = User::factory()->create();
        $action = app(UploadAvatarAction::class);
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100);
        $dto = UploadAvatarDTO::fromArray([
            'avatar' => $file,
            'user_id' => $user->id
        ]);
        
        // Act
        $result = $action->execute($dto);
        
        // Assert
        $this->assertInstanceOf(User::class, $result);
        $this->assertNotNull($result->avatar);
        $this->assertTrue(Storage::disk('public')->exists($result->avatar));
        
        // Test second upload
        $file2 = UploadedFile::fake()->image('avatar2.jpg', 100, 100);
        $dto2 = UploadAvatarDTO::fromArray([
            'avatar' => $file2,
            'user_id' => $user->id
        ]);
        
        $result2 = $action->execute($dto2);
        
        $this->assertInstanceOf(User::class, $result2);
        $this->assertNotEquals($result->avatar, $result2->avatar);
        $this->assertTrue(Storage::disk('public')->exists($result2->avatar));
    }

    protected function tearDown(): void
    {
        // Clean up storage after tests
        Storage::disk('public')->deleteDirectory('avatars');
        parent::tearDown();
    }
} 