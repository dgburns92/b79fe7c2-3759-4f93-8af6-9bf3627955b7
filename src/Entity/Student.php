<?php

declare(strict_types=1);

namespace App\Entity;

class Student
{
    public function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly int $yearLevel
    ) {
    }
}
