<?php

declare(strict_types=1);

namespace Basic\Message;

readonly class HelloRequest
{
    public function __construct(
        public string $message
    ) {
    }
}
