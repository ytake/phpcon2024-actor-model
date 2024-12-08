<?php

declare(strict_types=1);

namespace Calculator\Command;

readonly class Divide
{
    public function __construct(
        public float $value
    ) {
    }
}
