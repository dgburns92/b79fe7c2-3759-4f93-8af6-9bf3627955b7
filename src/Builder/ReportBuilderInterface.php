<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Student;

/**
 * This class is responsible to building a report with different filters.
 *
 * Other filters could be added to create more specific reports, e.g.:
 * public function forYear(Student $student): self;
 */
interface ReportBuilderInterface
{
    public function forStudent(Student $student): self;

    /** @return string[] */
    public function listDetails(): array;
}
