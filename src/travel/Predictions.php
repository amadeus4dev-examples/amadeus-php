<?php

declare(strict_types=1);

namespace Amadeus\Travel;

use Amadeus\Amadeus;
use Amadeus\Travel\Predictions\FlightDelay;

/**
 * A namespaced client for the
 * "/v1/travel/predictions" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getTravel()->getPredictions();
 *
 */
class Predictions
{
    /**
     * A namespaced client for the
     * "/v1/travel/predictions/flight-delay" endpoints.
     */
    private FlightDelay $flightDelay;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightDelay = new FlightDelay($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/travel/predictions/flight-delay" endpoints.
     * @return FlightDelay
     */
    public function getFlightDelay(): FlightDelay
    {
        return $this->flightDelay;
    }
}
