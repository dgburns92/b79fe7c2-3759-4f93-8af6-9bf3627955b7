<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Student;

abstract class AbstractStudentReportBuilder
{
    public function __construct(protected readonly Student $student)
    {
    }
}
