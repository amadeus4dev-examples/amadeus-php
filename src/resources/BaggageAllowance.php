<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class BaggageAllowance implements ResourceInterface
{
    private ?int $quantity = null;
    private ?int $weight = null;
    private ?string $weightUnit = null;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @return string|null
     */
    public function getWeightUnit(): ?string
    {
        return $this->weightUnit;
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
