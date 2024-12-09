<?php

declare(strict_types=1);

namespace Cart\Wallet\Command;

use Cart\Items;

readonly class Pay implements CommandInterface
{
    public function __construct(
        public Items $items,
        public int $shopperId
    ) {
    }
}
