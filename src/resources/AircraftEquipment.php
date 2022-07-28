<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightExtendedSegment, Leg
 * @see FlightExtendedSegment::getAircraft()
 * @see DatedFlightLeg::getAircraftEquipment()
 */
class AircraftEquipment implements ResourceInterface
{
    private ?string $code = null;
    private ?string $aircraftType = null;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getAircraftType(): ?string
    {
        return $this->aircraftType;
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
