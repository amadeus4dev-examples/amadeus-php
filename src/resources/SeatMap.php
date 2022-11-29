<?php

namespace Amadeus\Resources;

use Amadeus\Shopping\SeatMaps;

/**
 * A SeatMap object as returned by the SeatMap Display API.
 * @see SeatMaps::get()
 * @see SeatMaps::post()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/seatmap-display/api-reference
 */
class SeatMap extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?FlightEndpoint $departure = null;
    private ?FlightEndpoint $arrival = null;
    private ?string $carrierCode = null;
    private ?string $number = null;
    private ?OperatingFlight $operating = null;
    private ?AircraftEquipment $aircraft = null;
    private ?string $class = null;
    private ?string $flightOfferId = null;
    private ?string $segmentId = null;
    private array $decks = [];
    private ?object $aircraftCabinAmenities = null;
    private array $availableSeatsCounters = [];

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return FlightEndpoint|null
     */
    public function getDeparture(): ?FlightEndpoint
    {
        return $this->departure;
    }

    /**
     * @return FlightEndpoint|null
     */
    public function getArrival(): ?FlightEndpoint
    {
        return $this->arrival;
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
     * @return OperatingFlight|null
     */
    public function getOperating(): ?OperatingFlight
    {
        return $this->operating;
    }

    /**
     * @return AircraftEquipment|null
     */
    public function getAircraft(): ?AircraftEquipment
    {
        return $this->aircraft;
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
    public function getFlightOfferId(): ?string
    {
        return $this->flightOfferId;
    }

    /**
     * @return string|null
     */
    public function getSegmentId(): ?string
    {
        return $this->segmentId;
    }

    /**
     * @return array
     */
    public function getDecks(): array
    {
        return $this->decks;
    }

    /**
     * @return object|null
     */
    public function getAircraftCabinAmenities(): ?object
    {
        return $this->aircraftCabinAmenities;
    }

    /**
     * @return array
     */
    public function getAvailableSeatsCounters(): array
    {
        return $this->availableSeatsCounters;
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
