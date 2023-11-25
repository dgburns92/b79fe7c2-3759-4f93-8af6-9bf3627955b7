<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;

class JsonStudentRepository implements StudentRepositoryInterface
{
    /** @var array<string, Student> $students */
    private array $students;

    public function __construct()
    {
        $this->students = $this->loadStudents();
    }

    public function find(string $id): ?Student
    {
        return $this->students[$id] ?? null;
    }

    /** @return array<string, Student> */
    private function loadStudents(): array
    {
        $json = file_get_contents(__DIR__ . '/data/students.json');
        if ($json === false) {
            return [];
        }

        /** @var array<int, array{id: string, firstName: string, lastName: string, yearLevel: int}> $data*/
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $students = [];

        foreach ($data as $row) {
            $students[$row['id']] = new Student($row['id'], $row['firstName'], $row['lastName'], $row['yearLevel']);
        }

        return $students;
    }
}
