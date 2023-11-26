<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use App\Entity\StudentResponse;

interface StudentResponseRepositoryInterface
{
    public function findByStudent(Student $student): StudentResponse;

    public function findMostRecentByStudent(Student $student): StudentResponse;
}
