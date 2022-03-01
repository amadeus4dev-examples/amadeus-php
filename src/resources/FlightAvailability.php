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
    private String $type;
    private String $id;
    private String $originDestinationId;
    private String $source;
    private Bool $instantTicketRequired;
    private Bool $paymentCardRequired;
    private String $duration;
    private array $segments;

    /**
     * @return String
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return String
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getOriginDestinationId(): string
    {
        return $this->originDestinationId;
    }

    /**
     * @return String
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
     * @return String
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
    private String $closedStatus;
    private array $availabilityClasses;
    private String $id;
    private String $numberOfStops;
    private Bool $blacklistedInEU;
    private array $co2Emissions;
    private FlightEndpoint $departure;
    private FlightEndpoint $arrival;
    private String $carrierCode;
    private String $number;
    private AircraftEquipment $aircraft;
    private OperatingFlight $operating;
    private String $duration;
    private array $stops;

    /**
     * @return String
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
     * @return String
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return String
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
     * @return String
     */
    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    /**
     * @return String
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
     * @return String
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
    private String $class;
    private String $closedStatus;
    private TourAllotment $tourAllotment;

    /**
     * @return int
     */
    public function getNumberOfBookableSeats(): int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return String
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return String
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
    private String $weightUnit;
    private String $cabin;

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return String
     */
    public function getWeightUnit(): string
    {
        return $this->weightUnit;
    }

    /**
     * @return String
     */
    public function getCabin(): string
    {
        return $this->cabin;
    }

}

class FlightEndpoint
{
    private String $iataCode;
    private String $terminal;
    private String $at;

    /**
     * @return String
     */
    public function getIataCode(): string
    {
        return $this->iataCode;
    }

    /**
     * @return String
     */
    public function getTerminal(): string
    {
        return $this->terminal;
    }

    /**
     * @return String
     */
    public function getAt(): string
    {
        return $this->at;
    }

}

class AircraftEquipment
{
    private String $code;

    /**
     * @return String
     */
    public function getCode(): string
    {
        return $this->code;
    }

}

class OperatingFlight
{
    private String $carrierCode;

    /**
     * @return String
     */
    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

}

class FlightStop
{
    private String $iataCode;
    private String $duration;
    private String $arrivalAt;
    private String $departureAt;

    /**
     * @return String
     */
    public function getIataCode(): string
    {
        return $this->iataCode;
    }

    /**
     * @return String
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return String
     */
    public function getArrivalAt(): string
    {
        return $this->arrivalAt;
    }

    /**
     * @return String
     */
    public function getDepartureAt(): string
    {
        return $this->departureAt;
    }

}

namespace Amadeus\resources\FlightAvailability\AvailabilityClass;

class TourAllotment
{
    private String $tourName;
    private String $tourReference;
    private String $mode;
    private String $remainingSeats;

    /**
     * @return String
     */
    public function getTourName(): string
    {
        return $this->tourName;
    }

    /**
     * @return String
     */
    public function getTourReference(): string
    {
        return $this->tourReference;
    }

    /**
     * @return String
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return String
     */
    public function getRemainingSeats(): string
    {
        return $this->remainingSeats;
    }

}