<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\resources\FlightAvailability\ExtendedSegment;

class FlightAvailability
{
    private string $type;
    private string $id;
    private string $originDestinationId;
    private string $source;
    private bool $instantTicketRequired;
    private bool $paymentCardRequired;
    private string $duration;
    private array $segments;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
    public function getOriginDestinationId(): string
    {
        return $this->originDestinationId;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function isInstantTicketRequired(): bool
    {
        return $this->instantTicketRequired;
    }

    /**
     * @return bool
     */
    public function isPaymentCardRequired(): bool
    {
        return $this->paymentCardRequired;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return ExtendedSegment[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

}

namespace Amadeus\resources\FlightAvailability;

use Amadeus\resources\FlightAvailability\ExtendedSegment\AircraftEquipment;
use Amadeus\resources\FlightAvailability\ExtendedSegment\AvailabilityClass;
use Amadeus\resources\FlightAvailability\ExtendedSegment\Co2Emission;
use Amadeus\resources\FlightAvailability\ExtendedSegment\FlightEndpoint;
use Amadeus\resources\FlightAvailability\ExtendedSegment\FlightStop;
use Amadeus\resources\FlightAvailability\ExtendedSegment\OperatingFlight;

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
     */
    public function getAvailabilityClasses(): iterable
    {
        return $this->availabilityClasses;
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
     */
    public function getCo2Emissions(): iterable
    {
        return $this->co2Emissions;
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
     */
    public function getStops(): iterable
    {
        return $this->stops;
    }

}

namespace Amadeus\resources\FlightAvailability\ExtendedSegment;

use Amadeus\resources\FlightAvailability\AvailabilityClass\TourAllotment;

class AvailabilityClass
{
    private int $numberOfBookableSeats;
    private string $class;
    private string $closedStatus;
    private TourAllotment $tourAllotment;

    /**
     * @return int
     */
    public function getNumberOfBookableSeats(): int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getClosedStatus(): string
    {
        return $this->closedStatus;
    }

    /**
     * @return TourAllotment
     */
    public function getTourAllotment(): TourAllotment
    {
        return $this->tourAllotment;
    }

}

class Co2Emission
{
    private int $weight;
    private string $weightUnit;
    private string $cabin;

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getWeightUnit(): string
    {
        return $this->weightUnit;
    }

    /**
     * @return string
     */
    public function getCabin(): string
    {
        return $this->cabin;
    }

}

class FlightEndpoint
{
    private string $iataCode;
    private string $terminal;
    private string $at;

    /**
     * @return string
     */
    public function getIataCode(): string
    {
        return $this->iataCode;
    }

    /**
     * @return string
     */
    public function getTerminal(): string
    {
        return $this->terminal;
    }

    /**
     * @return string
     */
    public function getAt(): string
    {
        return $this->at;
    }

}

class AircraftEquipment
{
    private string $code;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

}

class OperatingFlight
{
    private string $carrierCode;

    /**
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

}

class FlightStop
{
    private string $iataCode;
    private string $duration;
    private string $arrivalAt;
    private string $departureAt;

    /**
     * @return string
     */
    public function getIataCode(): string
    {
        return $this->iataCode;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getArrivalAt(): string
    {
        return $this->arrivalAt;
    }

    /**
     * @return string
     */
    public function getDepartureAt(): string
    {
        return $this->departureAt;
    }

}

namespace Amadeus\resources\FlightAvailability\AvailabilityClass;

class TourAllotment
{
    private string $tourName;
    private string $tourReference;
    private string $mode;
    private string $remainingSeats;

    /**
     * @return string
     */
    public function getTourName(): string
    {
        return $this->tourName;
    }

    /**
     * @return string
     */
    public function getTourReference(): string
    {
        return $this->tourReference;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getRemainingSeats(): string
    {
        return $this->remainingSeats;
    }

}