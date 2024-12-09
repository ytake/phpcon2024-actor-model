<?php

declare(strict_types=1);

namespace Cart\Shopper;

use Cart\Basket\Command\Clear;
use Cart\Basket\Command\CommandInterface as BasketCommandInterface;
use Cart\Basket\Command\GetItems;
use Cart\Event\Paid;
use Cart\Items;
use Cart\Shopper\Command\PayBasket;
use Cart\Wallet\Command\CommandInterface as WalletCommandInterface;
use Cart\InMemoryStateProvider;
use Cart\Shopper\Value\Cash;
use Cart\Wallet\Command\Pay;
use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\ActorSystem\Message\Started;
use Phluxor\ActorSystem\Props;
use Phluxor\ActorSystem\Ref;
use Phluxor\Persistence\EventSourcedBehavior;
use Phluxor\Persistence\InMemoryProvider;
use Phluxor\Persistence\ProviderInterface;

class Actor implements ActorInterface
{
    private ?Ref $basketRef = null;
    private ?Ref $walletRef = null;
    private ProviderInterface $provider;

    public function __construct(
        private readonly int $shopperId,
        ?ProviderInterface $provider = null
    ) {
        $this->provider = $provider ?? $this->stateProvider();
    }

    public function receive(ContextInterface $context): void
    {
        // TODO: 実装してみよう
    }

    private function stateProvider(): InMemoryStateProvider
    {
        return new InMemoryStateProvider(new InMemoryProvider(1));
    }
}
