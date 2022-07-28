<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Location.
 * @see \Amadeus\Resources\Location::getDistance()
 */
class LocationDistance implements ResourceInterface
{
    private ?int $value = null;
    private ?string $unit = null;

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
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
