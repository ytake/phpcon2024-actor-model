<?php

declare(strict_types=1);

use Calculator\Actor;
use Calculator\Command\Add;
use Calculator\Command\PrintResult;
use Phluxor\ActorSystem;

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

require_once __DIR__ . '/vendor/autoload.php';

run(function () {
    go(function () {
        $system = ActorSystem::create();
        $ref = $system->root()->spawn(
            ActorSystem\Props::fromProducer(
                fn() => new Actor()
            )
        );
        $system->root()->send($ref, new Add(10));
        $system->root()->send($ref, new PrintResult());
        $system->shutdown();
    });
});
