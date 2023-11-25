<?php

declare(strict_types=1);

namespace App\Command\Student;

use App\Builder\DiagnosticReportBuilder;
use App\Builder\FeedbackReportBuilder;
use App\Builder\ProgressReportBuilder;
use App\Builder\ReportBuilderInterface;
use App\Entity\Student;
use App\Enum\ReportType;
use App\Factory\ReportBuilderFactoryInterface;
use App\Repository\StudentRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'student:generate-report')]
class GenerateReportCommand extends Command
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepo,
        private readonly SymfonyQuestionHelper $questionHelper,
        private readonly ReportBuilderFactoryInterface $reportBuilderFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Please enter the following');

        $student = $this->retrieveStudent($input, $output);
        if ($student === null) {
            $output->writeln('<error>Unable to find student with that ID, please try again</error>');
            return Command::FAILURE;
        }

        $reportType = $this->retrieveReportType($input, $output);

        $builder = $this->reportBuilderFactory->createBuilderFromType($reportType);

        $output->writeln(
            $builder->forStudent($student)->listDetails()
        );

        return Command::SUCCESS;
    }

    private function retrieveStudent(InputInterface $input, OutputInterface $output): ?Student
    {
        $studentId = $this->questionHelper->ask($input, $output, new Question('Student ID:'));

        if (is_string($studentId) === false) {
            return null;
        }

        return $this->studentRepo->find($studentId);
    }

    private function retrieveReportType(InputInterface $input, OutputInterface $output): ReportType
    {
        $choice = $this->questionHelper->ask(
            $input,
            $output,
            new ChoiceQuestion(
                'Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback):',
                [ReportType::Diagnostic, ReportType::Progress, ReportType::Feedback]
            )
        );

        return ReportType::from($choice);
    }
}
