<?php

declare(strict_types=1);

namespace Calculator;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;

readonly class Actor implements ActorInterface
{
    public function __construct(
        private Result $state = new Result()
    ) {
    }

    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        switch (true) {
            case $message instanceof Command\Add:
                $this->state->add($message->value);
                break;
            case $message instanceof Command\Clear:
                $this->state->reset();
                break;
            case $message instanceof Command\PrintResult:
                $context->logger()->info('Result is ' . $this->state->result());
                break;
            case $message instanceof Command\GetResult:
                $context->respond($this->state->result());
                break;
        }
    }
}
