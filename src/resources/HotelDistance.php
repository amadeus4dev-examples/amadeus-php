<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Hotel.
 * @see \Amadeus\Resources\Hotel::getDistance()
 */
class HotelDistance implements ResourceInterface
{
    private ?float $value = null;
    private ?string $unit = null;
    private ?string $displayValue = null;
    private ?string $inUnlimited = null;

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getDisplayValue(): ?string
    {
        return $this->displayValue;
    }

    /**
     * @return string|null
     */
    public function getInUnlimited(): ?string
    {
        return $this->inUnlimited;
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
