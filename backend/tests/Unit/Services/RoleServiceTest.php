<?php

namespace Tests\Unit\Services;

use App\Models\Cabinet;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CabinetRepository;
use App\Service\CourierService;
use App\Service\Report\SummaryService;
use App\Service\RoleService;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    use RefreshDatabase;

    private RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roleService = App::make(RoleService::class);
    }

    public function test_create_new_role()
    {

        $this->roleService->store([
            'name' => 'new role',
            'permissions' => []
        ]);

        $this->assertDatabaseCount('roles', 1);
    }

    public function test_update_role()
    {
        $role = Role::factory()->create();
        $this->roleService->update([
            'name' => 'new role',
            'permissions' => []
        ], $role);

        $this->assertDatabaseCount('roles', 1);
        $this->assertDatabaseHas('roles', [
            'name' => 'new role',
        ]);
    }

    public function test_delete_role()
    {
        $role = Role::factory()->create();

        $this->roleService->destroy($role);

        $this->assertDatabaseCount('roles', 0);
    }

    public function test_delete_role_user_has_role()
    {
        $role = Role::factory()->create();

        User::factory()->createOne([
            'role_id' => $role->id,
        ]);
        try {
            $this->roleService->destroy($role);

        }
        catch (\Exception $exception) {}
        $this->assertDatabaseCount('roles', 1);
    }
}
