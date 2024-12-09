<?php

declare(strict_types=1);

namespace Cart\Basket\Command;

use Cart\Item;

readonly class AddItem implements CommandInterface
{
    public function __construct(
        public Item $item,
        public int $shopperId,
    ) {
    }
}
