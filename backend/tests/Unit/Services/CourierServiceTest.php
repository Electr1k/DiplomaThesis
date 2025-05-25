<?php

namespace Tests\Unit\Services;

use App\Models\Cabinet;
use App\Repositories\CabinetRepository;
use App\Service\CourierService;
use App\Service\DostavistaClients\DostavistaClient;
use App\Service\Report\SummaryService;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CourierServiceTest extends TestCase
{
    use RefreshDatabase;

    private CourierService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = App::make(CourierService::class);
    }

    public function test_fetch_couriers()
    {
        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_COURIERS => Http::response([
                "is_successful" => true,
                "couriers" => [
                    [
                        "courier_id" => 966501,
                        "first_name" => "Иван",
                        "last_name" => "Иванов",
                        "middle_name" => "Иванович",
                        "status" => "approved",
                        "ban_end_datetime" => "2018-09-25T14:00:00+03:00",
                        "phone" => "79030000001",
                        "registered_datetime" => "2018-09-25T14:00:00+03:00",
                        "updated_datetime" => "2018-09-25T14:00:00+03:00",
                        "orders_completed_count" => 345,
                        "first_order_datetime" => "2018-09-25T14:00:00+03:00",
                        "last_order_datetime" => "2018-09-25T14:00:00+03:00"
                    ]
                ],
                "couriers_count" => 1,
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->service->fetch();

        $this->assertDatabaseCount('couriers', 1);
    }

    public function test_get_courier()
    {
        $result = $this->service->index([]);

        $this->assertDatabaseCount('couriers', $result->count());
        foreach ($result->toArray() as $item) {
            $this->assertDatabaseHas('cabinets', $item);
        }
    }

}
