<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightDate.
 * @see FlightDate
 */
class FlightDateLinks implements ResourceInterface
{
    private ?string $flightDestinations = null;
    private ?string $flightOffers = null;

    /**
     * @return string|null
     */
    public function getFlightDestinations(): ?string
    {
        return $this->flightDestinations;
    }

    /**
     * @return string|null
     */
    public function getFlightOffers(): ?string
    {
        return $this->flightOffers;
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
