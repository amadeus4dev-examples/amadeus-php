<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Arrival, Departure
 * @see FlightPointArrival, FlightPointDepartue
 */
class FlightPointGate implements ResourceInterface
{
    private ?string $mainGate = null;

    /**
     * @return string|null
     */
    public function getMainGate(): ?string
    {
        return $this->mainGate;
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
