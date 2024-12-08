<?php

declare(strict_types=1);

namespace Calculator\Command;

readonly class Multiply
{
    public function __construct(
        public float $value
    ) {
    }
}
