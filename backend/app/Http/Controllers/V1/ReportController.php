<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SummaryReportResource;
use App\Service\Report\SummaryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

}
