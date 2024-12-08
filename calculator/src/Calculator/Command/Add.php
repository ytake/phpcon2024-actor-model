<?php

declare(strict_types=1);

namespace Calculator\Command;

readonly class Add
{
    public function __construct(
        public float $value
    ) {
    }
}
