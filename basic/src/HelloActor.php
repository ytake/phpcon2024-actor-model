<?php

declare(strict_types=1);

namespace Basic;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\ActorSystem\Props;
use Phluxor\ActorSystem\ProtoBuf\Terminated;
use Phluxor\ActorSystem\Ref;

class HelloActor implements ActorInterface
{
    private ?Ref $sender = null;

    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        switch (true) {
            case $message instanceof Message\HelloRequest:
                $this->sender = $context->sender();
                $ref = $context->spawn(
                    Props::fromProducer(fn() => new WorldActor())
                );
                $context->request($ref, $message);
                break;
            case $message instanceof Message\HelloResponse:
                $context->send($this->sender, $message);
                break;
            case $message instanceof Terminated:
                var_dump($message->getWho()->getId());
                break;
        }
    }
}
