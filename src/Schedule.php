<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Schedule\Flights;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/schedule</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getSchedule();
 * </code>
 */
class Schedule
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v2/schedule/flights</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v2/schedule/flights</code> endpoints.
     * </p>
     * @return Flights
     */
    public function getFlights(): Flights
    {
        return $this->flights;
    }
}
