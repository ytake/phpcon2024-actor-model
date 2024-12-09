<?php

declare(strict_types=1);

namespace Cart\Basket\Command;

readonly class Clear implements CommandInterface
{
    public function __construct(
        public int $shopperId,
    ) {
    }
}
