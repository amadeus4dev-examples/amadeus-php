<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

use JsonMapper;
use JsonMapper_Exception;

class ExtendedSegment
{
    private string $closedStatus;
    private array $availabilityClasses;
    private string $id;
    private string $numberOfStops;
    private bool $blacklistedInEU;
    private array $co2Emissions;
    private FlightEndpoint $departure;
    private FlightEndpoint $arrival;
    private string $carrierCode;
    private string $number;
    private AircraftEquipment $aircraft;
    private OperatingFlight $operating;
    private string $duration;
    private array $stops;

    /**
     * @return string
     */
    public function getClosedStatus(): string
    {
        return $this->closedStatus;
    }

    /**
     * @return AvailabilityClass[]
     * @throws JsonMapper_Exception
     */
    public function getAvailabilityClasses(): iterable
    {
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->mapArray(
            $this->availabilityClasses, array(), AvailabilityClass::class
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumberOfStops(): string
    {
        return $this->numberOfStops;
    }

    /**
     * @return bool
     */
    public function isBlacklistedInEU(): bool
    {
        return $this->blacklistedInEU;
    }

    /**
     * @return Co2Emission[]
     * @throws JsonMapper_Exception
     */
    public function getCo2Emissions(): iterable
    {
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->mapArray(
            $this->co2Emissions, array(), Co2Emission::class
        );
    }

    /**
     * @return FlightEndpoint
     */
    public function getDeparture(): FlightEndpoint
    {
        return $this->departure;
    }

    /**
     * @return FlightEndpoint
     */
    public function getArrival(): FlightEndpoint
    {
        return $this->arrival;
    }

    /**
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return AircraftEquipment
     */
    public function getAircraft(): AircraftEquipment
    {
        return $this->aircraft;
    }

    /**
     * @return OperatingFlight
     */
    public function getOperating(): OperatingFlight
    {
        return $this->operating;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return FlightStop[]
     * @throws JsonMapper_Exception
     */
    public function getStops(): iterable
    {
        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->mapArray(
            $this->stops,  array(), FlightStop::class
        );
    }

}