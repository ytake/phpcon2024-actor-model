<?php

declare(strict_types=1);

use Cart\Basket\Actor;
use Cart\Basket\Command\AddItem;
use Cart\Basket\Command\CountRecoveredEvents;
use Cart\Basket\Command\GetItems;
use Cart\Basket\Command\RemoveItem;
use Cart\InMemoryStateProvider;
use Cart\Item;
use Cart\Items;
use Phluxor\ActorSystem;
use Phluxor\Persistence\EventSourcedBehavior;
use Phluxor\Persistence\InMemoryProvider;

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

require_once __DIR__ . '/vendor/autoload.php';

run(function () {
    go(function () {
        $system = ActorSystem::create();
        $props = ActorSystem\Props::fromProducer(
            fn() => new Actor(),
            ActorSystem\Props::withReceiverMiddleware(
                new EventSourcedBehavior(
                    new InMemoryStateProvider(new InMemoryProvider(1))
                )
            )
        );
        $spawn = $system->root()->spawnNamed($props, 'basket:1');
        $system->root()->send(
            $spawn->getRef(),
            new AddItem(
                Item::create('Apple Macbook Pro', 1, 2499), 2
            )
        );
        $_ = $system->root()->poisonFuture($spawn->getRef())->wait();
        $basketResurrected = $system->root()->spawnNamed($props, 'basket:1');
        $future = $system->root()->requestFuture($basketResurrected->getRef(), new GetItems(2), 2);
        /** @var Items $items */
        $items = $future->result()->value();
        var_dump($items->getProtobufItems()->serializeToJsonString());
        $system->root()->send(
            $spawn->getRef(),
            new AddItem(
                Item::create('Apple Mac Pro', 1, 10499), 2
            )
        );
        $future = $system->root()->requestFuture($basketResurrected->getRef(), new GetItems(2), 2);
        /** @var Items $items */
        $items = $future->result()->value();
        var_dump($items->getProtobufItems()->serializeToJsonString());
        // カートから商品を削除 Apple Mac Proを１つ削除
        $future = $system->root()->requestFuture(
            $basketResurrected->getRef(),
            new RemoveItem('Apple Mac Pro', 2),
            2
        );
        // カートから削除した商品を取得
        var_dump($future->result()->value()->serializeToJsonString());
        $future = $system->root()->requestFuture($basketResurrected->getRef(), new GetItems(2), 2);
        $items = $future->result()->value();
        // 現在のカートの中身を取得
        var_dump($items->getProtobufItems()->serializeToJsonString());
        $_ = $system->root()->poisonFuture($spawn->getRef())->wait();
        // 再度カートを復元
        $basketResurrected = $system->root()->spawnNamed($props, 'basket:1');
        $future = $system->root()->requestFuture($basketResurrected->getRef(), new GetItems(2), 2);
        $items = $future->result()->value();
        // カートの中身が復元されていることを確認
        var_dump($items->getProtobufItems()->serializeToJsonString());
        // イベントのリカバリー数を取得
        $future = $system->root()->requestFuture($basketResurrected->getRef(), new CountRecoveredEvents(2), 2);
        var_dump($future->result()->value());

        // 他のカートを作成
        $second = $system->root()->spawnNamed($props, 'basket:2');
        $future = $system->root()->requestFuture($second->getRef(), new GetItems(2), 2);
        // 空のカートが返却されることを確認、カートの中身は共有されない
        var_dump($future->result()->value()->getProtobufItems()->serializeToJsonString());
    });
});
