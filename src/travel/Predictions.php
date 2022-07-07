<?php

declare(strict_types=1);

namespace Amadeus\Travel;

use Amadeus\Amadeus;
use Amadeus\Travel\Predictions\FlightDelay;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/travel/predictions</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getTravel()->getPredictions();
 * </code>
 */
class Predictions
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/travel/predictions/flight-delay</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/travel/predictions/flight-delay</code> endpoints.
     * </p>
     * @return FlightDelay
     */
    public function getFlightDelay(): FlightDelay
    {
        return $this->flightDelay;
    }
}