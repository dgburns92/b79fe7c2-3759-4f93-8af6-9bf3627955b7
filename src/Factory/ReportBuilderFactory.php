<?php

declare(strict_types=1);

namespace App\Factory;

use App\Builder\DiagnosticReportBuilder;
use App\Builder\FeedbackReportBuilder;
use App\Builder\ProgressReportBuilder;
use App\Builder\ReportBuilderInterface;
use App\Enum\ReportType;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentResponseRepositoryInterface;

class ReportBuilderFactory implements ReportBuilderFactoryInterface
{
    public function __construct(
        private readonly StudentResponseRepositoryInterface $responseRepo,
        private readonly QuestionRepositoryInterface $questionRepo
    ) {
    }

    public function createBuilderFromType(ReportType $type): ReportBuilderInterface
    {
        return match ($type) {
            ReportType::Diagnostic => new DiagnosticReportBuilder($this->responseRepo, $this->questionRepo),
            ReportType::Progress => new ProgressReportBuilder(),
            ReportType::Feedback => new FeedbackReportBuilder($this->responseRepo, $this->questionRepo),
        };
    }
}
