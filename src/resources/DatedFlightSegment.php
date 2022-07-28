<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DatedFlight
 * @see DatedFlight::getSegments()
 */
class DatedFlightSegment implements ResourceInterface
{
    private ?string $boardPointIataCode = null;
    private ?string $offPointIataCode = null;
    private ?string $scheduledSegmentDuration = null;
    private ?object $partnership = null;

    /**
     * @return string|null
     */
    public function getBoardPointIataCode(): ?string
    {
        return $this->boardPointIataCode;
    }

    /**
     * @return string|null
     */
    public function getOffPointIataCode(): ?string
    {
        return $this->offPointIataCode;
    }

    /**
     * @return string|null
     */
    public function getScheduledSegmentDuration(): ?string
    {
        return $this->scheduledSegmentDuration;
    }

    /**
     * @return DatedFlightSegmentPartnership|null
     */
    public function getPartnership(): ?object
    {
        return Resource::toResourceObject(
            $this->partnership,
            DatedFlightSegmentPartnership::class
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
