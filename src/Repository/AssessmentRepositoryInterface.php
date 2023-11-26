<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Assessment;

interface AssessmentRepositoryInterface
{
    public function find(string $id): ?Assessment;
}
