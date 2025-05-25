<?php

namespace Tests\Feature\Security;

use App\Models\Cabinet;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CabinetRepository;
use App\Service\CourierService;
use App\Service\Report\SummaryService;
use App\Service\UserService;
use Database\Factories\RoleFactory;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SecurityTest extends TestCase
{


    public function test_get_courier_without_auth()
    {
        $this->getJson('/api/v1/couriers')
            ->assertStatus(401);
    }

    public function test_get_courier_without_permission()
    {
        $user = User::factory()->createOne([
            'role_id' => Role::factory()->createOne()->id
        ]);

        $token = JWTAuth::fromUser($user);

        $this->getJson('/api/v1/couriers', ['Authorization' => "Bearer $token"])
            ->assertStatus(403);
    }

    public function test_sql_injection()
    {
        $seeders = [new PermissionSeeder(), new RoleSeeder()];
        foreach ($seeders as $seeder) {
            $seeder->run();
        }

        $role = Role::query()->where('name', 'Главный админ')->first();

        $user = User::factory()->createOne([
            'role_id' => $role->id,
        ]);

        $token = JWTAuth::fromUser($user);

        $this->getJson('/api/v1/couriers?search=OR "1" = "1"; drop table users', ['Authorization' => "Bearer $token"])
            ->assertOk();

        $this->assertDatabaseHas('users');
    }

    public function test_xss_attack()
    {
        $seeders = [new PermissionSeeder(), new RoleSeeder()];
        foreach ($seeders as $seeder) {
            $seeder->run();
        }

        $role = Role::query()->where('name', 'Главный админ')->first();

        $user = User::factory()->createOne([
            'role_id' => $role->id,
        ]);

        $token = JWTAuth::fromUser($user);

        $this->getJson('/api/v1/couriers?search=<script>alert("Опасный скрипт")</script>', ['Authorization' => "Bearer $token"])
            ->assertOk();

    }

}
