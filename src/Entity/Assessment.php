<?php

declare(strict_types=1);

namespace App\Entity;

class Assessment
{
    /** @param array<int, array{questionId: string, position: int}> $questions */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly array $questions
    ) {
    }
}
