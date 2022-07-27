<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Shopping\Availability\FlightAvailabilities;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/shopping/availability</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getAvailability();
 * </code>
 */
class Availability
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/shopping/availability/flight-availabilities</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/shopping/availability/flight-availabilities</code> endpoints.
     * </p>
     * @return FlightAvailabilities
     */
    public function getFlightAvailabilities(): ?FlightAvailabilities
    {
        return $this->flightAvailabilities;
    }
}
