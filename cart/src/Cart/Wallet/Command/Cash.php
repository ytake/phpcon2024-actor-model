<?php

declare(strict_types=1);

namespace Cart\Wallet\Command;

readonly class Cash implements CommandInterface
{
    public function __construct(
        public int $left
    ) {
    }
}
