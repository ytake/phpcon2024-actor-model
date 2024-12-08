<?php

declare(strict_types=1);

namespace Calculator;

use Google\Protobuf\Internal\Message;
use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\Persistence\Mixin;
use Phluxor\Persistence\PersistentInterface;

class PersistenceActor implements ActorInterface, PersistentInterface
{
    use Mixin;

    public function receive(ContextInterface $context): void
    {
        // TODO: Implement receive() method.
    }

    private function updateState(Message $message): void
    {
        if (!$this->recovering()) {
            $this->persistenceReceive($message);
        }
    }
}
