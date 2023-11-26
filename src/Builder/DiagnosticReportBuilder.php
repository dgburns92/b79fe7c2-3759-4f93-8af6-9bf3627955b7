<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Question;
use App\Entity\StudentResponse;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentResponseRepositoryInterface;
use DateTimeInterface;
use RuntimeException;

class DiagnosticReportBuilder extends AbstractStudentReportBuilder implements ReportBuilderInterface
{
    public function __construct(
        private readonly StudentResponseRepositoryInterface $studentResponseRepo,
        private readonly QuestionRepositoryInterface $questionRepo
    ) {
    }

    public function listDetails(): array
    {
        if ($this->student === null) {
            throw new RuntimeException('You need to select a Student before generating a report.');
        }

        $studentResponse = $this->studentResponseRepo->findMostRecentCompletedByStudent($this->student);

        if ($studentResponse === null) {
            return ['Student has not completed any assessments'];
        }

        assert($studentResponse->completed instanceof DateTimeInterface);

        $details = [
            sprintf(
                "%s recently completed %s assessment on %s",
                $this->student->getFullName(),
                $studentResponse->assessment->name,
                $studentResponse->completed->format("jS F Y g:i A")
            ),
            sprintf(
                'He got %d questions right out of %d. Details by strand given below:',
                $studentResponse->rawScore,
                $studentResponse->getTotalQuestions()
            ),
            ''
        ];

        $questionDetailsByStrand = $this->buildQuestionDetailsForEachStrand($studentResponse);

        foreach ($questionDetailsByStrand as $strand => $amounts) {
            $details[] = sprintf("%s: %d out of %d correct", $strand, $amounts['totalCorrect'], $amounts['total']);
        }

        return $details;
    }

    /** @param Question[] $questions */
    private function findQuestionInList(string $questionId, array $questions): Question
    {
        foreach ($questions as $question) {
            if ($question->id === $questionId) {
                return $question;
            }
        }

        throw new RuntimeException('question id is not in the list');
    }

    /** @return array<string, array{total: int, totalCorrect: int}> */
    private function buildQuestionDetailsForEachStrand(StudentResponse $studentResponse): array
    {
        $questions = $this->questionRepo->findByIds($studentResponse->getQuestionIds());

        $detailsByStrands = [];

        foreach ($studentResponse->responses as $response) {
            $question = $this->findQuestionInList($response['questionId'], $questions);

            if (isset($detailsByStrands[$question->strand]) === false) {
                $detailsByStrands[$question->strand]['totalCorrect'] = 0;
                $detailsByStrands[$question->strand]['total'] = 0;
            }

            if ($response['response'] === $question->answer) {
                $detailsByStrands[$question->strand]['totalCorrect']++;
            }

            $detailsByStrands[$question->strand]['total']++;
        }

        return $detailsByStrands;
    }
}
