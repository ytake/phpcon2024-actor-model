<?php

declare(strict_types=1);

namespace Cart;

use Cart\ProtoBuf\Item as ProtoBufItem;

readonly class Item
{
    public function __construct(
        private ProtoBufItem $item
    ) {
    }

    public static function create(
        string $productId,
        int $number,
        float $unitPrice
    ): self {
        return new self(new ProtobufItem([
            'productId' => $productId,
            'number' => $number,
            'unitPrice' => $unitPrice,
        ]));
    }

    public function getProductId(): string
    {
        return $this->item->getProductId();
    }

    public function getNumber(): int
    {
        return $this->item->getNumber();
    }

    public function getUnitPrice(): float
    {
        return $this->item->getUnitPrice();
    }

    public function getProtobufItem(): ProtobufItem
    {
        return $this->item;
    }

    /**
     * 同一ProductIDであれば数量を加算した新しいItemを返す
     */
    public function aggregate(Item $other): ?Item
    {
        if ($this->getProductId() === $other->getProductId()) {
            return self::create(
                $this->getProductId(),
                $this->getNumber() + $other->getNumber(),
                $this->getUnitPrice()
            );
        }
        return null;
    }

    /**
     * 数量を更新した新しいItemを返す
     */
    public function update(int $number): Item
    {
        return self::create(
            $this->getProductId(),
            $number,
            $this->getUnitPrice()
        );
    }
}
