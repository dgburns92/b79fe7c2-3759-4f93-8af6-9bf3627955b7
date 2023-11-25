<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Student;

interface ReportBuilderInterface
{
    /** @return string[] */
    public function listDetails(): array;
}
