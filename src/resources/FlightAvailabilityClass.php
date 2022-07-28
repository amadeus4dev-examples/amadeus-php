<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightExtendedSegment
 * @see FlightExtendedSegment::getAvailabilityClasses()
 */
class FlightAvailabilityClass implements ResourceInterface
{
    private ?int $numberOfBookableSeats = null;
    private ?string $class = null;
    private ?string $closedStatus = null;
    private ?object $tourAllotment = null;

    /**
     * @return int|null
     */
    public function getNumberOfBookableSeats(): ?int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @return string|null
     */
    public function getClosedStatus(): ?string
    {
        return $this->closedStatus;
    }

    /**
     * @return FlightTourAllotment|null
     */
    public function getTourAllotment(): ?object
    {
        return Resource::toResourceObject(
            $this->tourAllotment,
            FlightTourAllotment::class
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
