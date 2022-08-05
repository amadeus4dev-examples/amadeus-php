<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Schedule\Flights;

/**
 * A namespaced client for the
 * "/schedule" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getSchedule();
 *
 */
class Schedule
{
    /**
     * A namespaced client for the
     * "/v2/schedule/flights" endpoints.
     */
    private Flights $flights;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flights = new Flights($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v2/schedule/flights" endpoints.
     * @return Flights
     */
    public function getFlights(): Flights
    {
        return $this->flights;
    }
}
