<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use App\Entity\StudentResponse;

interface StudentResponseRepositoryInterface
{
    /** @return StudentResponse[] */
    public function findByStudent(Student $student): array;

    public function findMostRecentCompletedByStudent(Student $student): ?StudentResponse;
}
