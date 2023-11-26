<?php

declare(strict_types=1);

namespace App\Repository\Json;

use App\Entity\Assessment;
use App\Repository\AssessmentRepositoryInterface;
use Exception;

class AssessmentRepository implements AssessmentRepositoryInterface
{
    /** @var array<string, Assessment> $students */
    private array $students;

    public function __construct()
    {
        $this->students = $this->loadAssessments();
    }

    public function find(string $id): ?Assessment
    {
        return $this->students[$id] ?? null;
    }

    public function findOrFail(string $id): Assessment
    {
        $assessment = $this->find($id);

        if ($assessment === null) {
            throw new Exception('Unable to find Assessment');
        }

        return $assessment;
    }

    /** @return array<string, Assessment> */
    private function loadAssessments(): array
    {
        $json = file_get_contents(__DIR__ . '/data/assessments.json');
        if ($json === false) {
            return [];
        }

        /** @var array<int, array{
         *     id: string,
         *     name: string,
         *     questions: array<int, array{questionId: string, position: int}>
         * }> $data
         */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $students = [];

        foreach ($data as $row) {
            $students[$row['id']] = new Assessment($row['id'], $row['name'], $row['questions']);
        }

        return $students;
    }
}
