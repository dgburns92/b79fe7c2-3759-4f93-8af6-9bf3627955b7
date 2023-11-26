<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\Option;

class Question
{
    /** @param Option[] $options */
    public function __construct(
        public readonly string $id,
        public readonly string $stem,
        public readonly string $type,
        public readonly string $strand,
        public readonly string $hint,
        public readonly array $options,
        public readonly string $answer
    ) {
    }
}
