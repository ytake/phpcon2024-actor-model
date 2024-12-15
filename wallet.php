<?php

declare(strict_types=1);

use Cart\InMemoryStateProvider;
use Cart\Item;
use Cart\Items;
use Cart\Shopper\Value\Cash;
use Cart\Wallet\Actor;
use Cart\Wallet\Command\Pay;
use Phluxor\ActorSystem;
use Phluxor\Persistence\EventSourcedBehavior;
use Phluxor\Persistence\InMemoryProvider;

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

require_once __DIR__ . '/vendor/autoload.php';

function products(): array
{
    return [
        'mbp' => Item::create('MacBook Pro', 1, 2499),
        'macPro' => Item::create('Apple Mac Pro', 1, 10499),
        'displays' => Item::create('4K Display', 3, 2499),
        'appleMouse' => Item::create('Apple Mouse', 1, 99),
        'appleKeyboard' => Item::create('Apple Keyboard', 1, 79),
    ];
}

run(function () {
    go(function () {
        $system = ActorSystem::create();
        $props = ActorSystem\Props::fromProducer(
            fn() => new Actor((string) Cash::VALUE),
            ActorSystem\Props::withReceiverMiddleware(
                new EventSourcedBehavior(
                    new InMemoryStateProvider(new InMemoryProvider(1))
                )
            )
        );
        $wallet = $system->root()->spawnNamed($props, 'wallet:1');
        $future = $system->root()->requestFuture(
            $wallet->getRef(),
            new Pay(Items::newItems(products()['macPro']), 1),
            1
        );
        var_dump($future->result()->value()->serializeToJsonString());
    });
});
