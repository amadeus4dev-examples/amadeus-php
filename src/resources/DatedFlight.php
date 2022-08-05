<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Schedule\Flights;

/**
 * A DatedFlight object as returned by the On-Demand Flight Status API.
 * @see Flights::get()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/on-demand-flight-status/api-reference
 */
class DatedFlight extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $scheduledDepartureDate = null;
    private ?object $flightDesignator= null;
    private ?array $flightPoints = null;
    private ?array $segments = null;
    private ?array $legs = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getScheduledDepartureDate(): ?string
    {
        return $this->scheduledDepartureDate;
    }

    /**
     * @return FlightDesignator|null
     */
    public function getFlightDesignator(): ?object
    {
        return Resource::toResourceObject(
            $this->flightDesignator,
            FlightDesignator::class
        );
    }

    /**
     * @return FlightPoint[]|null
     */
    public function getFlightPoints(): ?array
    {
        return Resource::toResourceArray(
            $this->flightPoints,
            FlightPoint::class
        );
    }

    /**
     * @return DatedFlightSegment[]|null
     */
    public function getSegments(): ?array
    {
        return Resource::toResourceArray(
            $this->segments,
            DatedFlightSegment::class
        );
    }

    /**
     * @return DatedFlightLeg[]|null
     */
    public function getLegs(): ?array
    {
        return Resource::toResourceArray(
            $this->legs,
            DatedFlightLeg::class
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
