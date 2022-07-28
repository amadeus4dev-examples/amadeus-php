<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DatedFlight
 * @see DatedFlight::getFlightPoints()
 */
class FlightPoint implements ResourceInterface
{
    private ?string $iataCode = null;
    private ?object $departure = null;
    private ?object $arrival = null;

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return FlightPointDeparture|null
     */
    public function getDeparture(): ?object
    {
        return Resource::toResourceObject(
            $this->departure,
            FlightPointDeparture::class
        );
    }

    /**
     * @return FlightPointArrival|null
     */
    public function getArrival(): ?object
    {
        return Resource::toResourceObject(
            $this->arrival,
            FlightPointArrival::class
        );
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
