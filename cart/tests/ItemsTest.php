<?php

declare(strict_types=1);

use Cart\Item;
use Cart\Items;
use Cart\ProtoBuf\Item as ProtoBufItem;
use PHPUnit\Framework\TestCase;

class ItemsTest extends TestCase
{
    public function testNewItemsWithSingleItem(): void
    {
        $productId = "test-product";
        $number = 2;
        $unitPrice = 19;
        $items = Items::newItems(Item::create($productId, $number, $unitPrice));

        $this->assertCount(1, $items->getProtobufItems()->getItems());
    }

    /**
     * Test for updating an existing item with a new quantity.
     */
    public function testUpdateExistingItem(): void
    {
        $productId = "test-product";
        $newNumber = 5;
        $items = Items::newItems(Item::create($productId, 2, 19));
        $items = $items->updateItem($productId, $newNumber);

        $this->assertCount(1, $items->getProtobufItems()->getItems());
        foreach ($items->getProtobufItems()->getItems() as $item) {
            if ($item->getProductId() === $productId) {
                $this->assertEquals($newNumber, $item->getNumber());
            }
        }
    }

    /**
     * Test for ensuring that updating a non-existing item does not affect the list.
     */
    public function testUpdateNonExistingItem(): void
    {
        $productId = "test-product";
        $items = Items::newItems(Item::create($productId, 2, 19));
        $items = $items->updateItem("non-existing-product", 5);

        $this->assertCount(1, $items->getProtobufItems()->getItems());
        $this->assertTrue($items->containsProduct($productId));
    }

    /**
     * Test for updating an item in an empty list results in no changes.
     */
    public function testUpdateItemInEmptyItems(): void
    {
        $items = Items::newItems();
        $items = $items->updateItem("any-product", 5);

        $this->assertCount(0, $items->getProtobufItems()->getItems());
    }

    public function testAddItemsWithNoItems(): void
    {
        $items = Items::newItems(Item::create("test-product", 2, 19));
        $items = $items->addItems(Items::newItems());
        $this->assertCount(1, $items->getProtobufItems()->getItems());
    }

    public function testAddItemsWithSingleItem(): void
    {
        $items = Items::newItems(Item::create("product1", 2, 10));
        $additionalItems = Items::newItems(Item::create("product2", 1, 15));
        $items = $items->addItems($additionalItems);
        $this->assertCount(2, $items->getProtobufItems()->getItems());
    }

    public function testAddItemsWithMultipleItems(): void
    {
        $items = Items::newItems(Item::create("product1", 2, 10));
        $additionalItems = Items::newItems(
            Item::create("product2", 1, 15),
            Item::create("product3", 5, 8)
        );
        $items = $items->addItems($additionalItems);
        $this->assertCount(3, $items->getProtobufItems()->getItems());
    }

    public function testAddItemsToEmptyItems(): void
    {
        $items = Items::newItems();
        $additionalItems = Items::newItems(
            Item::create("product1", 2, 25),
            Item::create("product2", 4, 30)
        );
        $items = $items->addItems($additionalItems);
        $this->assertCount(2, $items->getProtobufItems()->getItems());
    }

    public function testAggregateEmptyItems(): void
    {
        $emptyList = [];
        $items = Items::aggregateItems($emptyList);

        $this->assertCount(0, $items->getProtobufItems()->getItems());
    }

    public function testAggregateSingleItem(): void
    {
        $productId = "test-product";
        $number = 2;
        $unitPrice = 19;
        $protoItem = new ProtoBufItem();
        $protoItem->setProductId($productId);
        $protoItem->setNumber($number);
        $protoItem->setUnitPrice($unitPrice);

        $items = Items::aggregateItems([$protoItem]);

        $this->assertCount(1, $items->getProtobufItems()->getItems());
    }

    public function testAggregateMultipleItems(): void
    {
        $productId1 = "test-product-1";
        $number1 = 3;
        $unitPrice1 = 15;
        $protoItem1 = new ProtoBufItem();
        $protoItem1->setProductId($productId1);
        $protoItem1->setNumber($number1);
        $protoItem1->setUnitPrice($unitPrice1);

        $productId2 = "test-product-2";
        $number2 = 1;
        $unitPrice2 = 25;
        $protoItem2 = new ProtoBufItem();
        $protoItem2->setProductId($productId2);
        $protoItem2->setNumber($number2);
        $protoItem2->setUnitPrice($unitPrice2);

        $items = Items::aggregateItems([$protoItem1, $protoItem2]);

        $this->assertCount(2, $items->getProtobufItems()->getItems());
    }

    public function testNewItemsWithMultipleItems(): void
    {
        $productId = "test-product";
        $number = 2;
        $unitPrice = 19;
        $item1 = Item::create($productId, $number, $unitPrice);
        $item2 = Item::create($productId, $number, $unitPrice);
        $items = Items::newItems($item1, $item2);
        $this->assertCount(2, $items->getProtobufItems()->getItems());
    }

    public function testNewItemsWithNoItems(): void
    {
        $items = Items::newItems();
        $this->assertCount(0, $items->getProtobufItems()->getItems());
    }

    public function testContainsProductWithExistingProductId(): void
    {
        $productId = "test-product";
        $items = Items::newItems(Item::create($productId, 2, 19));

        $this->assertTrue($items->containsProduct($productId));
    }

    public function testContainsProductWithNonExistingProductId(): void
    {
        $items = Items::newItems(Item::create("test-product", 2, 19));

        $this->assertFalse($items->containsProduct("non-existing-product"));
    }

    public function testContainsProductWithEmptyItems(): void
    {
        $items = Items::newItems();

        $this->assertFalse($items->containsProduct("any-product"));
    }

    public function testRemoveExistingItem(): void
    {
        $productId = "test-product";
        $items = Items::newItems(Item::create($productId, 2, 19));
        $items = $items->removeItem($productId);

        $this->assertCount(0, $items->getProtobufItems()->getItems());
        $this->assertFalse($items->containsProduct($productId));
    }

    public function testRemoveNonExistingItem(): void
    {
        $productId = "test-product";
        $items = Items::newItems(Item::create($productId, 2, 19));
        $items = $items->removeItem("non-existing-product");

        $this->assertCount(1, $items->getProtobufItems()->getItems());
        $this->assertTrue($items->containsProduct($productId));
    }

    public function testRemoveItemFromEmptyItems(): void
    {
        $items = Items::newItems();
        $items = $items->removeItem("any-product");

        $this->assertCount(0, $items->getProtobufItems()->getItems());
    }
}
