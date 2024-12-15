<?php

declare(strict_types=1);

namespace Cart\Basket;

use Cart\Basket\Command\AddItem;
use Cart\Basket\Command\Clear;
use Cart\Basket\Command\CountRecoveredEvents;
use Cart\Basket\Command\GetItems;
use Cart\Basket\Command\RecoveredEventsCount;
use Cart\Basket\Command\RemoveItem;
use Cart\Event\Added;
use Cart\Event\Cleared;
use Cart\Event\ItemRemoved;
use Cart\Event\ItemUpdated;
use Cart\Event\Replaced;
use Cart\Items;
use Google\Protobuf\Internal\Message;
use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\Persistence\Message\OfferSnapshot;
use Phluxor\Persistence\Message\RequestSnapshot;
use Phluxor\Persistence\Mixin;
use Phluxor\Persistence\PersistentInterface;

class Actor implements ActorInterface, PersistentInterface
{
    use Mixin;

    private Items $state;
    private int $nrEventsRecovered = 0;

    public function __construct()
    {
        $this->state = Items::newItems();
    }

    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        switch (true) {
            case $message instanceof RequestSnapshot:
                $this->persistenceSnapshot($this->state->getProtobufItems());
                break;
            case $message instanceof AddItem:
                $this->updateState(new Added([
                    'item' => $message->item->getProtobufItem()
                ]));
                break;
            case $message instanceof GetItems:
                $context->respond($this->state);
                break;
            case $message instanceof RemoveItem:
                $removed = new ItemRemoved([
                    'productId' => $message->productId
                ]);
                $context->respond($removed);
                $this->updateState($removed);
                break;
            case $message instanceof Clear:
                $this->updateState(new Cleared([
                    'items' => $this->state->getProtobufItems()
                ]));
                break;
            case $message instanceof CountRecoveredEvents:
                $context->respond(new RecoveredEventsCount($this->nrEventsRecovered));
                break;
        }
    }

    public function receiveRecover(mixed $message): void
    {
        switch (true) {
            case $message instanceof OfferSnapshot:
                $this->state = Items::fromProtobufItems($message->snapshot);
                break;
            case $message instanceof Message:
                $this->nrEventsRecovered++;
                $this->updateState($message);
                break;
        }
    }

    private function updateState(Message $message): void
    {
        if (!$this->recovering()) {
            $this->persistenceReceive($message);
        }
        switch (true) {
            case $message instanceof Added:
                $this->state = $this->state->add($message->getItem());
                break;
            case $message instanceof ItemRemoved:
                $this->state = $this->state->removeItem($message->getProductId());
                break;
            case $message instanceof ItemUpdated:
                $this->state = $this->state->updateItem($message->getProductId(), $message->getNumber());
                break;
            case $message instanceof Replaced:
                $this->state = $message->getItems();
                break;
            case $message instanceof Cleared:
                $this->state = $this->state->clear();
                $this->persistenceSnapshot($this->state->getProtobufItems());
                break;
        }
    }
}
