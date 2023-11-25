<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Student;

abstract class AbstractStudentReportBuilder implements ReportBuilderInterface
{
    protected ?Student $student = null;

    public function forStudent(Student $student): static
    {
        $this->student = $student;

        return $this;
    }
}
