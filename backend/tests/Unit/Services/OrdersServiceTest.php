<?php

namespace Tests\Unit\Services;

use App\Models\Cabinet;
use App\Models\DateTimeMark;
use App\Models\Enums\DateTimeMarkType;
use App\Repositories\CabinetRepository;
use App\Service\CourierService;
use App\Service\DostavistaClients\DostavistaClient;
use App\Service\OrderService;
use App\Service\Report\SummaryService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrdersServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = App::make(OrderService::class);
    }

    public function test_fetch_orders()
    {

        DateTimeMark::create([
            'type' => DateTimeMarkType::LAST_IMPORT_ORDERS->value,
            'date_time' => Carbon::now()->subMinutes(10),
        ]);

        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_ORDERS => Http::response([
                "is_successful" => true,
                "orders" => [
                    [
                        "order_id" => 966501,
                        "courier_id" => 966501,
                        "courier_first_name" => "Иван",
                        "courier_last_name" => "Иванов",
                        "courier_middle_name" => "Иванович",
                        "payment_method" => "noncash",
                        "order_status" => "completed",
                        "order_payment_amount" => "100.00",
                        "service_commission_amount" => "100.00",
                        "partner_commission_amount" => "100.00",
                        "courier_payment_amount" => "100.00",
                        "courier_additional_payments_amount" => "100.00",
                        "order_accepted_datetime" => "2018-09-25T14:00:00+03:00",
                        "order_finished_datetime" => "2018-09-25T14:00:00+03:00",
                        "order_first_point_address" => "г Москва",
                        "order_last_point_address" => "г Москва, Москва-Товарная МЦД",
                        "order_lead_time" => "14:00:00",
                        "updated_datetime" => "2018-09-25T14:00:00+03:00"
                    ]
                ],
                "next_page_id" => null,
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->orderService->fetch();

        $this->assertDatabaseCount('orders', 1);
    }

    public function test_fetch_orders_without_time_mark()
    {
        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_ORDERS => Http::response([
                "is_successful" => true,
                "orders" => [
                    [
                        "order_id" => 966501,
                        "courier_id" => 966501,
                        "courier_first_name" => "Иван",
                        "courier_last_name" => "Иванов",
                        "courier_middle_name" => "Иванович",
                        "payment_method" => "noncash",
                        "order_status" => "completed",
                        "order_payment_amount" => "100.00",
                        "service_commission_amount" => "100.00",
                        "partner_commission_amount" => "100.00",
                        "courier_payment_amount" => "100.00",
                        "courier_additional_payments_amount" => "100.00",
                        "order_accepted_datetime" => "2018-09-25T14:00:00+03:00",
                        "order_finished_datetime" => "2018-09-25T14:00:00+03:00",
                        "order_first_point_address" => "г Москва",
                        "order_last_point_address" => "г Москва, Москва-Товарная МЦД",
                        "order_lead_time" => "14:00:00",
                        "updated_datetime" => "2018-09-25T14:00:00+03:00"
                    ]
                ],
                "next_page_id" => null,
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->orderService->fetch();

        $this->assertDatabaseCount('orders', 1);
    }

}
