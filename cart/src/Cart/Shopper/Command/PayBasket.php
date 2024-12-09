<?php

declare(strict_types=1);

namespace Cart\Shopper\Command;

readonly class PayBasket implements CommandInterface
{
    public function __construct(
        public int $shopperId,
    ) {
    }
}
