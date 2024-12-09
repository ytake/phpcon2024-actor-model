<?php

declare(strict_types=1);

namespace Cart\Basket\Command;

readonly class RemoveItem implements CommandInterface
{
    public function __construct(
        public string $productId,
        public int $shopperId,
    ) {
    }
}
