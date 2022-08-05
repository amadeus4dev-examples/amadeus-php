<?php

declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;
use Amadeus\Airport\Predictions\OnTime;

/**
 * A namespaced client for the
 * "/v1/airport/predictions" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getAirport()->getPredictions();
 *
 */
class Predictions
{
    /**
     * A namespaced client for the
     * "/v1/airport/predictions" endpoints.
     */
    private OnTime $onTime;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->onTime = new OnTime($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/airport/predictions/on-time" endpoints.
     *
     * @return OnTime
     */
    public function getOnTime(): OnTime
    {
        return $this->onTime;
    }
}
