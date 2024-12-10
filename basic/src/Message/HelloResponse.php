<?php

declare(strict_types=1);

namespace Basic\Message;

readonly class HelloResponse
{
    public function __construct(
        public string $message
    ) {
    }
}
