<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function find(string $id): ?Student
    {
        return null;
    }
}
