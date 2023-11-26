<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;

class StudentResponse
{
    /** @param array<int, array{questionId: string, response: string}> $responses */
    public function __construct(
        public readonly string $id,
        public readonly Assessment $assessment,
        public readonly DateTimeInterface $assigned,
        public readonly DateTimeInterface $started,
        public readonly DateTimeInterface $completed,
        public readonly Student $student,
        public readonly int $yearLevel,
        public readonly array $responses,
        public readonly int $rawScore
    ) {
    }

    /** @return string[] */
    public function getQuestionIds(): array
    {
        return array_map(static fn(array $response) => $response['questionId'], $this->responses);
    }
}
