<?php

declare(strict_types=1);

namespace Cart\Wallet\Command;

readonly class AmountSpent implements CommandInterface
{
    public function __construct(
        public int $amount
    ) {
    }
}
