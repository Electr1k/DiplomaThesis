<?php

namespace Tests\Unit\Services;

use App\Models\Cabinet;
use App\Repositories\CabinetRepository;
use App\Service\CourierService;
use App\Service\Report\SummaryService;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SummaryServiceTest extends TestCase
{
    use RefreshDatabase;

    private SummaryService $summaryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->summaryService = App::make(SummaryService::class);
    }

    public function test_get_summary_report_by_year()
    {
        Artisan::call('db:seed');

        $data = $this->summaryService->index(['group' => 'year']);

        $this->assertNotEmpty($data);
    }

    public function test_get_summary_report_by_month()
    {
        Artisan::call('db:seed');

        $data = $this->summaryService->index(['group' => 'month']);

        $this->assertNotEmpty($data);

    }

    public function test_get_summary_report_by_week()
    {
        Artisan::call('db:seed');

        $data = $this->summaryService->index(['group' => 'week']);

        $this->assertNotEmpty($data);

    }

    public function test_get_summary_report_by_day()
    {
        Artisan::call('db:seed');

        $data = $this->summaryService->index(['group' => 'day']);

        $this->assertNotEmpty($data);

    }

    public function test_get_summary_report()
    {
        Artisan::call('db:seed');

        $data = $this->summaryService->index([]);

        $this->assertNotEmpty($data);

    }
}
