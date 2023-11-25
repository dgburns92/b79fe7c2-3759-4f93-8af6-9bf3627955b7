<?php

declare(strict_types=1);

namespace App\Builder;

class ProgressReportBuilder extends AbstractStudentReportBuilder implements ReportBuilderInterface
{
    public function listDetails(): array
    {
        return [];
    }
}
