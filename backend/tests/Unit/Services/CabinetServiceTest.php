<?php

namespace Tests\Unit\Services;

use App\Jobs\CreateCourierJob;
use App\Models\Cabinet;
use App\Service\CabinetService;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CabinetServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CabinetService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = App::make(CabinetService::class);
    }

    public function test_fetch_cabinets()
    {
        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_COURIER_PARTNERS => Http::response([
                "is_successful" => true,
                "courier_partners" => [
                    [
                        "courier_partner_id" => 1,
                        "region_name" => "Москва",
                        "vehicle_type_name" => "Легковой автомобиль",
                        "legal_name" => "ИП Партнеров П.П.",
                        "partner_commission_part" => "0.03",
                        "is_for_taking_available_couriers" => true
                    ]
                ],
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->service->fetch();

        $this->assertDatabaseCount('cabinets', 1);
    }

    public function test_get_cabinets()
    {

        $result = $this->service->index([]);

        $this->assertDatabaseCount('cabinets', $result->count());
        foreach ($result->toArray() as $item) {
            $this->assertDatabaseHas('cabinets', $item);
        }
    }

}
