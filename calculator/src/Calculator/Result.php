<?php

declare(strict_types=1);

namespace Calculator;

use Calculator\ProtoBuf\CalculationResult;

class Result
{
    private CalculationResult $result;

    public function __construct()
    {
        $this->result = new CalculationResult();
    }

    /**
     * @return CalculationResult
     */
    public function reset(): CalculationResult
    {
        $this->result = new CalculationResult();
        return $this->result;
    }

    /**
     * Adds a given value to the current result.
     *
     * @param float $value The value to be added to the current result.
     * @return CalculationResult The result of the addition as a CalculationResult object.
     */
    public function add(float $value): CalculationResult
    {
        $this->result->setResult($this->result->getResult() + $value);
        return $this->result;
    }

    /**
     * Subtracts a given value from the current result.
     *
     * @param float $value The value to be subtracted from the current result.
     * @return CalculationResult The result of the subtraction as a CalculationResult object.
     */
    public function subtract(float $value): CalculationResult
    {
        $this->result->setResult($this->result->getResult() - $value);
        return $this->result;
    }

    /**
     * Divides the current result by the provided value and returns a new CalculationResult.
     *
     * @param float $value The divisor value.
     * @return CalculationResult
     */
    public function divide(float $value): CalculationResult
    {
        $this->result->setResult($this->result->getResult() / $value);
        return $this->result;
    }

    /**
     * Multiplies the given value with the current result and returns a new CalculationResult object.
     *
     * @param float $value The value to multiply with the current result.
     * @return CalculationResult A new CalculationResult object with the multiplied result.
     */
    public function multiply(float $value): CalculationResult
    {
        $this->result->setResult($this->result->getResult() * $value);
        return $this->result;
    }

    /**
     * @return float
     */
    public function result(): float
    {
        return $this->result->getResult();
    }
}
