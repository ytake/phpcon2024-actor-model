<?php

declare(strict_types=1);

namespace Calculator;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;

class Actor implements ActorInterface
{
    public function __construct(
        private CalculationResult $state = new CalculationResult()
    ) {
    }

    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        switch (true) {
            case $message instanceof Command\Add:
                $this->state = $this->state->add($message->value);
                break;
            case $message instanceof Command\Clear:
                $this->state = $this->state->reset();
                break;
            case $message instanceof Command\PrintResult:
                $context->logger()->info('Result is ' . $this->state->getResult());
                break;
            case $message instanceof Command\GetResult:
                $context->respond($this->state->getResult());
                break;
        }
    }
}
