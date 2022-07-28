<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DatedFlight, Partnership
 * @see DatedFlight::getFlightDesignator()
 * @see DatedFlightSegmentPartnership::getOperatingFlight()
 */
class FlightDesignator implements ResourceInterface
{
    private ?string $carrierCode = null;
    private ?int $flightNumber = null;
    private ?string $operationalSuffix = null;

    /**
     * @return string|null
     */
    public function getCarrierCode(): ?string
    {
        return $this->carrierCode;
    }

    /**
     * @return int|null
     */
    public function getFlightNumber(): ?int
    {
        return $this->flightNumber;
    }

    /**
     * @return string|null
     */
    public function getOperationalSuffix(): ?string
    {
        return $this->operationalSuffix;
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
