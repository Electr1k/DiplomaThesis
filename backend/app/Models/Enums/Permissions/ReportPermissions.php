<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum ReportPermissions: string implements HasTitle
{
    case SUMMARY = 'report-summary';

    public function title(): string
    {
        return match ($this) {
            self::SUMMARY => 'Просмотр сводного отчета',
        };
    }
}
