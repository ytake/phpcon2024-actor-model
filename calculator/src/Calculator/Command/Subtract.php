<?php

declare(strict_types=1);

namespace Calculator\Command;

readonly class Subtract
{
    public function __construct(
        public float $value
    ) {
    }
}
