<?php

declare(strict_types=1);

namespace Calculator;

use Calculator\ProtoBuf\CalculationResult as ProtobufCalculationResult;

readonly class CalculationResult
{
    public function __construct(
        private ProtobufCalculationResult $result = new ProtobufCalculationResult()
    ) {
    }

    public static function create(float $result = 0.0): self
    {
        $protobuf = new ProtobufCalculationResult();
        $protobuf->setResult($result);
        return new self($protobuf);
    }

    public function getProtobufCalculationResult(): ProtobufCalculationResult
    {
        return $this->result;
    }

    public function getResult(): float
    {
        return $this->result->getResult();
    }

    /**
     * @return CalculationResult
     */
    public function reset(): self
    {
        return self::create(0.0);
    }

    /**
     * Adds a given value to the current result.
     *
     * @param float $value The value to be added to the current result.
     * @return CalculationResult The result of the addition as a CalculationResult object.
     */
    public function add(float $value): CalculationResult
    {
        return self::create($this->getResult() + $value);
    }

    /**
     * Subtracts a given value from the current result.
     *
     * @param float $value The value to be subtracted from the current result.
     * @return CalculationResult The result of the subtraction as a CalculationResult object.
     */
    public function subtract(float $value): CalculationResult
    {
        return self::create($this->getResult() - $value);
    }

    /**
     * Divides the current result by the provided value and returns a new CalculationResult.
     *
     * @param float $value The divisor value.
     * @return CalculationResult
     */
    public function divide(float $value): CalculationResult
    {
        return self::create($this->getResult() / $value);
    }

    /**
     * Multiplies the given value with the current result and returns a new CalculationResult object.
     *
     * @param float $value The value to multiply with the current result.
     * @return CalculationResult A new CalculationResult object with the multiplied result.
     */
    public function multiply(float $value): CalculationResult
    {
        return self::create($this->getResult() * $value);
    }
}
