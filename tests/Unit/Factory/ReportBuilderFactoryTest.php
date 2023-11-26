<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Builder\DiagnosticReportBuilder;
use App\Builder\FeedbackReportBuilder;
use App\Builder\ProgressReportBuilder;
use App\Builder\ReportBuilderInterface;
use App\Enum\ReportType;
use App\Factory\ReportBuilderFactory;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentResponseRepositoryInterface;
use Generator;
use PHPUnit\Framework\TestCase;

class ReportBuilderFactoryTest extends TestCase
{
    /**
     * @return \Generator<string, array{expected: class-string<ReportBuilderInterface>}>
     */
    public function generateBuilders(): Generator
    {
        yield ReportType::Diagnostic->value => [
            'type' => ReportType::Diagnostic,
            'expected' => DiagnosticReportBuilder::class
        ];

        yield ReportType::Progress->value => [
            'type' => ReportType::Progress,
            'expected' => ProgressReportBuilder::class
        ];
        yield ReportType::Feedback->value => [
            'type' => ReportType::Feedback,
            'expected' => FeedbackReportBuilder::class
        ];
    }

    /**
     * @dataProvider generateBuilders
     */
    public function testCreateBuilderFromTypeWithCases(ReportType $type, string $expected): void
    {
        // Arrange
        $questionRepo = $this->createMock(QuestionRepositoryInterface::class);
        $studentResponseRepo = $this->createMock(StudentResponseRepositoryInterface::class);
        $factory = new ReportBuilderFactory($studentResponseRepo, $questionRepo);

        // Act
        $actual = $factory->createBuilderFromType($type);

        // Assert
        self::assertInstanceOf($expected, $actual);
    }
}
