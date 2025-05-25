<?php

namespace Tests\Unit\Services;

use App\Models\Role;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = App::make(UserService::class);
    }

    public function test_create_new_user()
    {
        Storage::fake('public');
        $user = $this->userService->store([
            'name' => 'test',
            'surname' => 'test',
            'email' => 'test@test.ru',
            'password' => 'password',
            'photo' => UploadedFile::fake()->create('avatar.jpg'),
            'role_id' => Role::factory()->create()->id,
        ]);

        $this->assertDatabaseCount('users', 1);

        Storage::disk('public')->assertExists("users/profile-$user->id");
    }

    public function test_create_new_user_without_image()
    {
        $this->assertTrue(true);
        $user = $this->userService->store([
            'name' => 'test',
            'surname' => 'test',
            'email' => 'test@test.ru',
            'password' => 'password',
            'role_id' => Role::factory()->create()->id,
        ]);

        $this->assertDatabaseCount('users', 1);
    }
}
