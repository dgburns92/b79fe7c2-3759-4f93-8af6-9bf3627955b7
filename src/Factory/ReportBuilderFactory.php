<?php

declare(strict_types=1);

namespace App\Factory;

use App\Builder\DiagnosticReportBuilder;
use App\Builder\FeedbackReportBuilder;
use App\Builder\ProgressReportBuilder;
use App\Builder\ReportBuilderInterface;
use App\Enum\ReportType;

class ReportBuilderFactory implements ReportBuilderFactoryInterface
{
    public function createBuilderFromType(ReportType $type): ReportBuilderInterface
    {
        return match ($type) {
            ReportType::Diagnostic => new DiagnosticReportBuilder(),
            ReportType::Progress => new ProgressReportBuilder(),
            ReportType::Feedback => new FeedbackReportBuilder(),
        };
    }
}
