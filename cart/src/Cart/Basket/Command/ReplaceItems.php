<?php

declare(strict_types=1);

namespace Cart\Basket\Command;

use Cart\Items;

readonly class ReplaceItems implements CommandInterface
{
    public function __construct(
        public Items $items,
        public int $shopperId,
    ) {
    }
}
