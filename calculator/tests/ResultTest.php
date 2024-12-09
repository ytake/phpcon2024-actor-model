<?php

declare(strict_types=1);

use Calculator\CalculationResult;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 *
 * This test class verifies the functionality of the reset method in the CalculationResult class.
 */
class ResultTest extends TestCase
{
    /**
     * Test that reset method returns a new CalculationResult instance
     * and does not retain any previous state.
     */
    public function testResetReturnsNewCalculationResult(): void
    {
        // Arrange
        $result = new CalculationResult();

        // Act
        $resetResult = $result->reset();

        // Assert
        $this->assertInstanceOf(
            CalculationResult::class,
            $resetResult,
            "Reset does not return a CalculationResult instance."
        );
    }

    /**
     * Test multiplying two positive numbers returns the correct result.
     */
    public function testMultiplyPositiveNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(3.0);

        // Act
        $newResult = $result->multiply(2.0);

        // Assert
        $this->assertEquals(6.0, $newResult->getResult(), "Multiplication of positive numbers failed.");
    }

    /**
     * Test multiplying two negative numbers returns the correct result.
     */
    public function testMultiplyNegativeNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(-3.0);

        // Act
        $newResult = $result->multiply(-2.0);

        // Assert
        $this->assertEquals(6.0, $newResult->getResult(), "Multiplication of negative numbers failed.");
    }

    /**
     * Test multiplying a positive number by a negative number returns the correct result.
     */
    public function testMultiplyPositiveAndNegativeNumber(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(3.0);

        // Act
        $newResult = $result->multiply(-2.0);

        // Assert
        $this->assertEquals(-6.0, $newResult->getResult(), "Multiplication of positive and negative number failed.");
    }

    /**
     * Test multiplying by zero returns zero.
     */
    public function testMultiplyByZero(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(3.0);

        // Act
        $newResult = $result->multiply(0.0);

        // Assert
        $this->assertEquals(0.0, $newResult->getResult(), "Multiplication by zero failed.");
    }

    /**
     * Test that adding two positive numbers returns the correct result.
     */
    public function testAddPositiveNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->add(3.0);

        // Assert
        $this->assertEquals(8.0, $newResult->getResult(), "Addition of positive numbers failed.");
    }

    /**
     * Test that adding two negative numbers returns the correct result.
     */
    public function testAddNegativeNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(-5.0);

        // Act
        $newResult = $result->add(-3.0);

        // Assert
        $this->assertEquals(-8.0, $newResult->getResult(), "Addition of negative numbers failed.");
    }

    /**
     * Test that adding a positive and a negative number returns the correct result.
     */
    public function testAddPositiveAndNegativeNumber(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->add(-3.0);

        // Assert
        $this->assertEquals(2.0, $newResult->getResult(), "Addition of positive and negative number failed.");
    }

    /**
     * Test that adding zero does not change the result.
     */
    public function testAddZero(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->add(0.0);

        // Assert
        $this->assertEquals(5.0, $newResult->getResult(), "Addition of zero failed.");
    }

    /**
     * Test that a new CalculationResult instance has a default state.
     */
    public function testResetResultHasDefaultState(): void
    {
        // Arrange
        $result = new CalculationResult();

        // Act
        $resetResult = $result->reset();

        // Assert
        $this->assertEquals(0.0, $resetResult->getResult(), "Reset result does not have default state of 0.0.");
    }

    /**
     * Test subtracting two positive numbers returns the correct result.
     */
    public function testSubtractPositiveNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->subtract(3.0);

        // Assert
        $this->assertEquals(2.0, $newResult->getResult(), "Subtraction of positive numbers failed.");
    }

    /**
     * Test subtracting two negative numbers returns the correct result.
     */
    public function testSubtractNegativeNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(-5.0);

        // Act
        $newResult = $result->subtract(-3.0);

        // Assert
        $this->assertEquals(-2.0, $newResult->getResult(), "Subtraction of negative numbers failed.");
    }

    /**
     * Test subtracting a negative number from a positive number returns the correct result.
     */
    public function testSubtractPositiveAndNegativeNumber(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->subtract(-3.0);

        // Assert
        $this->assertEquals(8.0, $newResult->getResult(), "Subtraction of positive and negative number failed.");
    }

    /**
     * Test subtracting zero results in no change.
     */
    public function testSubtractZero(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(5.0);

        // Act
        $newResult = $result->subtract(0.0);

        // Assert
        $this->assertEquals(5.0, $newResult->getResult(), "Subtraction of zero failed.");
    }

    /**
     * Test subtracting from zero.
     */
    public function testSubtractFromZero(): void
    {
        // Arrange
        $result = new CalculationResult();

        // Act
        $newResult = $result->subtract(5.0);

        // Assert
        $this->assertEquals(-5.0, $newResult->getResult(), "Subtraction from zero failed.");
    }


    /**
     * Test dividing a positive number by another positive number returns the correct result.
     */
    public function testDividePositiveNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(10.0);

        // Act
        $newResult = $result->divide(2.0);

        // Assert
        $this->assertEquals(5.0, $newResult->getResult(), "Division of positive numbers failed.");
    }

    /**
     * Test dividing a negative number by another negative number returns the correct result.
     */
    public function testDivideNegativeNumbers(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(-10.0);

        // Act
        $newResult = $result->divide(-2.0);

        // Assert
        $this->assertEquals(5.0, $newResult->getResult(), "Division of negative numbers failed.");
    }

    /**
     * Test dividing a positive number by a negative number returns the correct result.
     */
    public function testDividePositiveAndNegativeNumber(): void
    {
        // Arrange
        $result = new CalculationResult();
        $result = $result->add(10.0);

        // Act
        $newResult = $result->divide(-2.0);

        // Assert
        $this->assertEquals(-5.0, $newResult->getResult(), "Division of positive and negative number failed.");
    }

    /**
     * Test dividing by zero throws an exception.
     */
    public function testDivideByZeroThrowsException(): void
    {
        // Expect exception
        $this->expectException(\DivisionByZeroError::class);

        // Arrange
        $result = new CalculationResult();
        $result = $result->add(10.0);

        // Act & Assert
        $result->divide(0.0);
    }

    /**
     * Test dividing zero returns zero.
     */
    public function testDivideZero(): void
    {
        // Arrange
        $result = new CalculationResult();

        // Act
        $newResult = $result->divide(5.0);

        // Assert
        $this->assertEquals(0.0, $newResult->getResult(), "Division of zero failed.");
    }
}
