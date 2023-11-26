<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;

interface QuestionRepositoryInterface
{
    /**
     * @param string[] $ids
     * @return Question[]
     */
    public function findByIds(array $ids): array;
}
