<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;

interface StudentRepositoryInterface
{
    public function find(string $id): ?Student;

    public function findOrFail(string $id): Student;
}
