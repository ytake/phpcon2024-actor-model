<?php

declare(strict_types=1);

namespace Basic;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;

class WorldActor implements ActorInterface
{
    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        if ($message instanceof Message\HelloRequest) {
            $response = new Message\HelloResponse('Hello Child, ' . $message->message);
            $context->respond($response);
        }
    }
}
