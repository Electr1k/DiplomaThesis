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
use App\Service\TransactionService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    private TransactionService $transactionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionService = App::make(TransactionService::class);
    }

    public function test_fetch_transactions()
    {
        DateTimeMark::query()->create([
            'type' => DateTimeMarkType::LAST_IMPORT_TRANSACTIONS->value,
            'date_time' => Carbon::now()->subMinutes(10),
        ]);

        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_TRANSACTIONS => Http::response([
                "is_successful" => true,
                "transactions" => [
                    [
                        "transaction_id" => 966501,
                        "courier_id" => 966501,
                        "order_id" => 966501,
                        "transaction_type" => "order",
                        "amount" => "100.00",
                        "partner_commission_amount" => "100.00",
                        "courier_payment_amount" => "100.00",
                        "updated_datetime" => "2018-09-25T14:00:00+03:00",
                        "rollback_transaction_id" => 966501,
                        "transaction_status" => "active"
                    ]
                ],
                "next_page_id" => null,
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->transactionService->fetch();

        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_fetch_transactions_without_time_mark()
    {

        Http::fake([
            config('dostavista.client.host').DostavistaClient::URI_V1_TRANSACTIONS => Http::response([
                "is_successful" => true,
                "transactions" => [
                    [
                        "transaction_id" => 966501,
                        "courier_id" => 966501,
                        "order_id" => 966501,
                        "transaction_type" => "order",
                        "amount" => "100.00",
                        "partner_commission_amount" => "100.00",
                        "courier_payment_amount" => "100.00",
                        "updated_datetime" => "2018-09-25T14:00:00+03:00",
                        "rollback_transaction_id" => 966501,
                        "transaction_status" => "active"
                    ]
                ],
                "next_page_id" => null,
                "server_datetime" => "2018-09-25T14:00:00+03:00"
            ]),
        ]);

        $this->transactionService->fetch();

        $this->assertDatabaseCount('transactions', 1);
    }

}
