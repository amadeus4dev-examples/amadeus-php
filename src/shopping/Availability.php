<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Shopping\Availability\FlightAvailabilities;

/**
 * A namespaced client for the
 * "/v1/shopping/availability" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getAvailability();
 *
 */
class Availability
{
    /**
     * A namespaced client for the
     * "/v1/shopping/availability/flight-availabilities" endpoints.
     */
    private FlightAvailabilities $flightAvailabilities;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightAvailabilities = new FlightAvailabilities($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/availability/flight-availabilities" endpoints.
     * @return FlightAvailabilities
     */
    public function getFlightAvailabilities(): ?FlightAvailabilities
    {
        return $this->flightAvailabilities;
    }
}
