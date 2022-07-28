<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DatedFlight
 * @see DatedFlight::getLegs()
 */
class DatedFlightLeg implements ResourceInterface
{
    private ?string $boardPointIataCode = null;
    private ?string $offPointIataCode = null;
    private ?object $aircraftEquipment = null;
    private ?string $scheduledLegDuration = null;

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
     * @return AircraftEquipment|null
     */
    public function getAircraftEquipment(): ?object
    {
        return Resource::toResourceObject(
            $this->aircraftEquipment,
            AircraftEquipment::class
        );
    }

    /**
     * @return string|null
     */
    public function getScheduledLegDuration(): ?string
    {
        return $this->scheduledLegDuration;
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
