<?php

declare(strict_types=1);

namespace App\Builder;

class DiagnosticReportBuilder extends AbstractStudentReportBuilder implements ReportBuilderInterface
{
    public function listDetails(): array
    {
        return [];
    }
}
