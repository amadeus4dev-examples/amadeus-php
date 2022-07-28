<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Segment
 * @see DatedFlightSegment::getPartnership()
 */
class DatedFlightSegmentPartnership implements ResourceInterface
{
    private ?object $operatingFlight = null;

    /**
     * @return FlightDesignator|null
     */
    public function getOperatingFlight(): ?object
    {
        return Resource::toResourceObject(
            $this->operatingFlight,
            FlightDesignator::class
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
