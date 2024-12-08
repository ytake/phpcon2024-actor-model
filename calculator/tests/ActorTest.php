<?php

declare(strict_types=1);

use Calculator\Actor;
use Calculator\Command;
use Phluxor\ActorSystem;
use PHPUnit\Framework\TestCase;

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

class ActorTest extends TestCase
{
    public function testReceiveAddCommand(): void
    {
        run(function () {
            go(function () {
                $system = ActorSystem::create();
                $ref = $system->root()->spawn(
                    ActorSystem\Props::fromProducer(fn() => new Actor())
                );
                $system->root()->send($ref, new Command\Add(10));
                $system->root()->send($ref, new Command\PrintResult());
            });
        });
    }

    public function testStateResetAfterActorRestart(): void
    {
        run(function () {
            go(function () {
                $system = ActorSystem::create();
                $ref = $system->root()->spawn(
                    ActorSystem\Props::fromProducer(fn() => new Actor())
                );
                $system->root()->send($ref, new Command\Add(10));
                $system->root()->send($ref, new Command\PrintResult());
                $system->root()->send($ref, new Command\Clear());
                $system->root()->send($ref, new Command\PrintResult());
                $system->root()->send($ref, new Command\Add(10));
                $system->root()->send($ref, new Command\Add(1010));
                $system->root()->send($ref, new Command\PrintResult());
                $system->shutdown();
                $system = ActorSystem::create();
                $ref = $system->root()->spawn(
                    ActorSystem\Props::fromProducer(fn() => new Actor())
                );
                $system->root()->send($ref, new Command\PrintResult());
            });
        });
    }
}
