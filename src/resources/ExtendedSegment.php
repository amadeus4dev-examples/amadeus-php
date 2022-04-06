<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class ExtendedSegment
{
    private ?string $closedStatus = null;
    private ?array $availabilityClasses = null;
    private ?string $id = null;
    private ?int $numberOfStops = null;
    private ?bool $blacklistedInEU = null;
    private ?array $co2Emissions = null;
    private ?object $departure = null;
    private ?object $arrival = null;
    private ?string $carrierCode = null;
    private ?string $number = null;
    private ?object $aircraft = null;
    private ?object $operating = null;
    private ?string $duration = null;
    private ?array $stops = null;

    /**
     * @return string|null
     */
    public function getClosedStatus(): ?string
    {
        return $this->closedStatus;
    }

    /**
     * @return AvailabilityClass[]|null
     */
    public function getAvailabilityClasses(): ?iterable
    {
        return Resource::toResourceArray(
            $this->availabilityClasses,
            AvailabilityClass::class
        );
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumberOfStops(): ?int
    {
        return $this->numberOfStops;
    }

    /**
     * @return bool|null
     */
    public function getBlacklistedInEU(): ?bool
    {
        return $this->blacklistedInEU;
    }

    /**
     * @return Co2Emission[]|null
     */
    public function getCo2Emissions(): ?iterable
    {
        return Resource::toResourceArray(
            $this->co2Emissions,
            Co2Emission::class
        );
    }

    /**
     * @return FlightEndpoint|null
     */
    public function getDeparture(): ?object
    {
        return Resource::toResourceObject(
            $this->departure,
            FlightEndpoint::class
        );
    }

    /**
     * @return FlightEndpoint|null
     */
    public function getArrival(): ?object
    {
        return Resource::toResourceObject(
            $this->arrival,
            FlightEndpoint::class
        );
    }

    /**
     * @return string|null
     */
    public function getCarrierCode(): ?string
    {
        return $this->carrierCode;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return AircraftEquipment|null
     */
    public function getAircraft(): ?object
    {
        return Resource::toResourceObject(
            $this->aircraft,
            AircraftEquipment::class
        );
    }

    /**
     * @return OperatingFlight|null
     */
    public function getOperating(): ?object
    {
        return Resource::toResourceObject(
            $this->operating,
            OperatingFlight::class
        );
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return FlightStop[]|null
     */
    public function getStops(): ?iterable
    {
        return Resource::toResourceArray(
            $this->stops,
            FlightStop::class
        );
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
