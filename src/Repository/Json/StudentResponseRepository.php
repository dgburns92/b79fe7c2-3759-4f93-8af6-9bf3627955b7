<?php

declare(strict_types=1);

namespace App\Repository\Json;

use App\Entity\Student;
use App\Entity\StudentResponse;
use App\Repository\AssessmentRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use App\Repository\StudentResponseRepositoryInterface;
use DateTimeImmutable;
use DateTimeInterface;

class StudentResponseRepository implements StudentResponseRepositoryInterface
{
    /** @var array<string, StudentResponse> $studentResponse */
    private array $studentResponse;

    public function __construct(
        private readonly StudentRepositoryInterface $studentRepo,
        private readonly AssessmentRepositoryInterface $assessmentRepo
    ) {
        $this->studentResponse = $this->loadStudentResponses();
    }

    public function findByStudent(Student $student): array
    {
        return array_values(
            array_filter(
                $this->studentResponse,
                static fn(StudentResponse $response) => $response->student->id === $student->id
            )
        );
    }

    public function findMostRecentCompletedByStudent(Student $student): ?StudentResponse
    {
        $byStudent = $this->findByStudent($student);

        if (count($byStudent) === 0) {
            return null;
        }

        $completed = array_values(
            array_filter(
                $byStudent,
                static fn(StudentResponse $studentResponse) => $studentResponse->completed instanceof DateTimeInterface
            )
        );

        if (count($completed) === 0) {
            return null;
        }

        return array_reduce($completed, function (StudentResponse $max, StudentResponse $current) {
            assert($current->completed instanceof DateTimeInterface && $max->completed instanceof DateTimeInterface);
            return ($current->completed->getTimestamp() > $max->completed->getTimestamp()) ? $current : $max;
        }, $completed[0]);
    }

    /** @return array<string, StudentResponse> */
    private function loadStudentResponses(): array
    {
        $json = file_get_contents(__DIR__ . '/data/student-responses.json');
        if ($json === false) {
            return [];
        }

        /** @var array<int, array{
         *     id: string,
         *     assessmentId: string,
         *     assigned: string,
         *     started?: string,
         *     completed?: string,
         *     student: array{id: string, yearLevel: int},
         *     responses: array<int, array{questionId: string, response: string}>,
         *     results: array{rawScore: int}
         * }> $data
         */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $studentResponse = [];

        foreach ($data as $row) {
            $studentResponse[$row['id']] = new StudentResponse(
                id: $row['id'],
                assessment: $this->assessmentRepo->findOrFail($row['assessmentId']),
                assigned: $this->loadDate($row['assigned']),
                started: isset($row['started']) ? $this->loadDate($row['started']) : null,
                completed: isset($row['completed']) ? $this->loadDate($row['completed']) : null,
                student: $this->studentRepo->findOrFail($row['student']['id']),
                yearLevel: $row['student']['yearLevel'],
                responses: $row['responses'],
                rawScore: $row['results']['rawScore'],
            );
        }

        return $studentResponse;
    }

    private function loadDate(string $date): DateTimeInterface
    {
        $dateObject =  DateTimeImmutable::createFromFormat('d/m/Y H:i:s', $date);
        assert($dateObject instanceof DateTimeInterface);

        return $dateObject;
    }
}
