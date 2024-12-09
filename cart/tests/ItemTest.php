<?php

declare(strict_types=1);

use Cart\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCreateWithValidParams(): void
    {
        $productId = "test-product";
        $number = 2;
        $unitPrice = 19;

        $item = Item::create($productId, $number, $unitPrice);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($productId, $item->getProductId());
        $this->assertEquals($number, $item->getNumber());
        $this->assertEquals($unitPrice, $item->getUnitPrice());
    }

    public function testUpdateWithValidNumber(): void
    {
        $productId = "test-product";
        $initialNumber = 2;
        $updatedNumber = 5;
        $unitPrice = 19;

        $item = Item::create($productId, $initialNumber, $unitPrice);
        $updatedItem = $item->update($updatedNumber);

        $this->assertInstanceOf(Item::class, $updatedItem);
        $this->assertEquals($productId, $updatedItem->getProductId());
        $this->assertEquals($updatedNumber, $updatedItem->getNumber());
        $this->assertEquals($unitPrice, $updatedItem->getUnitPrice());
    }

    public function testUpdateWithZeroNumber(): void
    {
        $productId = "test-product-zero";
        $initialNumber = 2;
        $updatedNumber = 0;
        $unitPrice = 19;

        $item = Item::create($productId, $initialNumber, $unitPrice);
        $updatedItem = $item->update($updatedNumber);

        $this->assertInstanceOf(Item::class, $updatedItem);
        $this->assertEquals($productId, $updatedItem->getProductId());
        $this->assertEquals($updatedNumber, $updatedItem->getNumber());
        $this->assertEquals($unitPrice, $updatedItem->getUnitPrice());
    }

    public function testUpdateWithNegativeNumber(): void
    {
        $productId = "test-product-negative";
        $initialNumber = 2;
        $updatedNumber = -1;
        $unitPrice = 19;

        $item = Item::create($productId, $initialNumber, $unitPrice);
        $updatedItem = $item->update($updatedNumber);

        $this->assertInstanceOf(Item::class, $updatedItem);
        $this->assertEquals($productId, $updatedItem->getProductId());
        $this->assertEquals($updatedNumber, $updatedItem->getNumber());
        $this->assertEquals($unitPrice, $updatedItem->getUnitPrice());
    }

    public function testAggregateWithSameProductId(): void
    {
        $productId = "test-product";
        $number1 = 2;
        $number2 = 3;
        $unitPrice = 19;

        $item1 = Item::create($productId, $number1, $unitPrice);
        $item2 = Item::create($productId, $number2, $unitPrice);

        $aggregatedItem = $item1->aggregate($item2);

        $this->assertInstanceOf(Item::class, $aggregatedItem);
        $this->assertEquals($productId, $aggregatedItem->getProductId());
        $this->assertEquals($number1 + $number2, $aggregatedItem->getNumber());
        $this->assertEquals($unitPrice, $aggregatedItem->getUnitPrice());
    }

    public function testAggregateWithDifferentProductId(): void
    {
        $productId1 = "test-product-1";
        $productId2 = "test-product-2";
        $number1 = 2;
        $number2 = 3;
        $unitPrice = 19;

        $item1 = Item::create($productId1, $number1, $unitPrice);
        $item2 = Item::create($productId2, $number2, $unitPrice);

        $aggregatedItem = $item1->aggregate($item2);

        $this->assertNull($aggregatedItem);
    }

    public function testCreateWithZeroQuantity(): void
    {
        $productId = "test-zero-quantity";
        $number = 0;
        $unitPrice = 19;

        $item = Item::create($productId, $number, $unitPrice);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($productId, $item->getProductId());
        $this->assertEquals($number, $item->getNumber());
        $this->assertEquals($unitPrice, $item->getUnitPrice());
    }

    public function testCreateWithNegativeQuantity(): void
    {
        $productId = "test-negative-quantity";
        $number = -1;
        $unitPrice = 19;

        $item = Item::create($productId, $number, $unitPrice);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($productId, $item->getProductId());
        $this->assertEquals($number, $item->getNumber());
        $this->assertEquals($unitPrice, $item->getUnitPrice());
    }

    public function testCreateWithFreePrice(): void
    {
        $productId = "test-free-price";
        $number = 1;
        $unitPrice = 0;

        $item = Item::create($productId, $number, $unitPrice);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($productId, $item->getProductId());
        $this->assertEquals($number, $item->getNumber());
        $this->assertEquals($unitPrice, $item->getUnitPrice());
    }
}
