<?php

declare(strict_types=1);

namespace App\Dto;

class Option
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly string $value,
    ) {
    }
}
