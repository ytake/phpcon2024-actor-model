<?php

declare(strict_types=1);

namespace Cart;

use Cart\ProtoBuf\Item as ProtoBufItem;
use Cart\ProtoBuf\Items as ProtoBufItems;
use Google\Protobuf\Internal\RepeatedField;

readonly class Items
{
    private function __construct(
        private ProtobufItems $items
    ) {
    }

    public static function fromProtobufItems(ProtobufItems $items): self
    {
        return new self($items);
    }

    /**
     * 複数のItemインスタンスからItemsを生成する
     */
    public static function newItems(Item ...$args): self
    {
        $protobufItems = new ProtobufItems();
        $protobufItems->setItems(array_map(
            fn(Item $i) => $i->getProtobufItem(),
            $args
        ));
        return self::aggregateItems($protobufItems->getItems());
    }

    /**
     * protobuf\Item配列からItemsを再集約する
     * @param ProtoBufItem[]|RepeatedField $list
     * @return self
     */
    public static function aggregateItems(array|RepeatedField $list): self
    {
        $protobufItems = new ProtobufItems();
        $protobufItems->setItems($list);
        return self::fromProtobufItems($protobufItems);
    }

    public function getProtobufItems(): ProtobufItems
    {
        return $this->items;
    }

    /**
     * 新しいItemを追加したItemsを返す
     */
    public function add(ProtoBufItem $newItem): self
    {
        $newItems = [];
        foreach($this->items->getItems() as $item) {
            $newItems[] = $item;
        }
        $newItems[] = $newItem;
        return self::aggregateItems($newItems);
    }

    /**
     * 他のItems内のItem群を追加したItemsを返す
     */
    public function addItems(Items $other): self
    {
        $newItems = [];
        foreach($this->items->getItems() as $item) {
            $newItems[] = $item;
        }
        foreach($other->getProtobufItems()->getItems() as $item) {
            $newItems[] = $item;
        }
        return self::aggregateItems($newItems);
    }

    public function containsProduct(string $productId): bool
    {
        foreach ($this->items->getItems() as $item) {
            if ($item->getProductId() === $productId) {
                return true;
            }
        }
        return false;
    }

    public function removeItem(string $productId): self
    {
        $newList = [];
        foreach ($this->items->getItems() as $item) {
            if ($item->getProductId() !== $productId) {
                $newList[] = $item;
            }
        }
        return self::aggregateItems($newList);
    }

    public function updateItem(string $productId, int $number): self
    {
        $newList = [];
        foreach ($this->items->getItems() as $item) {
            if ($item->getProductId() === $productId) {
                $item->setNumber($number);
            }
            $newList[] = $item;
        }
        return self::aggregateItems($newList);
    }

    public function clear(): self
    {
        return self::aggregateItems([]);
    }
}
