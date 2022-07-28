<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightOffer, etc.
 * @see FlightOffer::getItineraries()
 */
class FlightItineraries implements ResourceInterface
{
    private ?string $duration = null;
    private ?array $segments = null;

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return FlightExtendedSegment[]|null
     */
    public function getSegments(): ?array
    {
        return Resource::toResourceArray(
            $this->segments,
            FlightExtendedSegment::class
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
