<?php

namespace Tests\Unit\Services;

use App\Jobs\CreateCourierJob;
use App\Models\Cabinet;
use App\Models\Courier;
use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\Citizenship;
use App\Models\User;
use App\Service\CourierService;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CourierRegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    private CourierService $courierService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->courierService = App::make(CourierService::class);
    }

    public function test_create_new_courier_registration()
    {

        Queue::fake();
        /** @var Cabinet $cabinet */
        $cabinet = Cabinet::factory()->createOne();

        $data = [
            'name' => 'Test',
            'surname' => 'Test',
            'phone' => '899998765432',
            'citizenship' => Citizenship::DOMESTIC,
            'courier_partner_id' => $cabinet->courier_partner_id,
        ];

        $this->courierService->store($data);

        $this->assertDatabaseCount('courier_registrations', 1);
        $this->assertDatabaseHas('courier_registrations', $data);
        Queue::assertPushed(CreateCourierJob::class);
    }

    public function test_update_courier_registration()
    {
        Queue::fake();

        $seeders = [new PermissionSeeder(), new RoleSeeder(), new UserSeeder()];
        array_map(fn ($seeder) => $seeder->run(), $seeders);

        /** @var User $user */
        $user = User::first();
        $this->withHeader('Authorization', 'Bearer ' . JWTAuth::fromUser($user));

        $registration = CourierRegistration::factory()->createOne();

        $data = [
            'name' => 'Test',
            'citizenship' => Citizenship::FOREIGN,
        ];

        $this->assertNotEmpty($user);
//        $this->courierService->updateRegistration($registration, $data);
//
//        $this->assertDatabaseCount('courier_registrations', 1);
//        $this->assertDatabaseHas('courier_registrations', $data);
//        Queue::assertPushed(CreateCourierJob::class);
    }
}
