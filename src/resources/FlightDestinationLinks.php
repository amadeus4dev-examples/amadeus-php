<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightDestination.
 * @see FlightDestination
 */
class FlightDestinationLinks implements ResourceInterface
{
    private ?string $flightDates = null;
    private ?string $flightOffers = null;

    /**
     * @return string|null
     */
    public function getFlightDates(): ?string
    {
        return $this->flightDates;
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
