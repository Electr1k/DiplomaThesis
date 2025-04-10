<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SummaryReportResource;
use App\Models\Enums\Orders\OrderStatus;
use App\Models\Order;
use App\Service\Report\SummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function __construct(private readonly SummaryService $summaryService){}

    /**
     * Получение сводного отчета.
     */
    public function indexSummary(Request $request): AnonymousResourceCollection
    {
        return SummaryReportResource::collection($this->summaryService->index($request->validate([])));
    }

    public function dashboardOrders(): JsonResponse
    {
        $data = Order::query()
            ->where('order_finished_datetime', '>', now()->subDays(10)->startOfDay())
            ->select(
                DB::raw('order_finished_datetime::date as date'),
                DB::raw('count(*) as count'),
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json(['data' => $data]);
    }

}
