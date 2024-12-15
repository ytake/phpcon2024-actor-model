<?php

declare(strict_types=1);

namespace Cart\Wallet;

use Cart\Event\Paid;
use Cart\ProtoBuf\Item;
use Cart\ProtoBuf\Items;
use Cart\Wallet\Command\NotEnoughCash;
use Cart\Wallet\Command\Pay;
use Google\Protobuf\Internal\Message;
use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\Persistence\Mixin;
use Phluxor\Persistence\PersistentInterface;

class Actor implements ActorInterface, PersistentInterface
{
    use Mixin;

    private string $persistenceId;
    private string $cash;
    private string $amountSpent;

    public function __construct(
        string $cash
    ) {
        $this->cash = $cash;
        $this->amountSpent = "0";
    }

    public function receive(ContextInterface $context): void
    {
        $message = $context->message();
        switch (true) {
            case $message instanceof Pay:
                $sender = $context->sender();
                $items = $message->items->getProtobufItems();
                $totalSpent = $this->addSpending($items);
                if (bccomp(bcsub($this->cash, $totalSpent), "0", 2) > 0) {
                    $event = new Paid([
                        'items' => $items,
                        'shopperId' => $message->shopperId
                    ]);
                    $this->updateState($event);
                    $context->send($sender, $event);
                    break;
                }
                $notEnough = new NotEnoughCash(intval(bcsub($this->cash, $this->amountSpent)));
                $context->actorSystem()->getEventStream()->publish($notEnough);
                break;
        }
    }

    public function receiveRecover(mixed $message): void
    {
        if ($message instanceof Message) {
            $this->updateState($message);
        }
    }

    private function updateState(Message $message): void
    {
        if (!$this->recovering()) {
            $this->persistenceReceive($message);
        }
        if ($message instanceof Paid) {
            $this->amountSpent = $this->addSpending($message->getItems());
        }
    }

    /**
     * items合計計算: amountSpent + sum(item.unitPrice * item.number)
     * @param Items $items
     * @return string
     */
    private function addSpending(Items $items): string
    {
        $total = $this->amountSpent;
        /** @var Item $item */
        foreach ($items->getItems() as $item) {
            $spent = bcmul((string)$item->getUnitPrice(), (string)$item->getNumber(), 2);
            $total = bcadd($total, $spent, 2);
        }
        return $total;
    }
}
