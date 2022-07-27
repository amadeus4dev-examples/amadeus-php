<?php

declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;
use Amadeus\Airport\Predictions\OnTime;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/airport/predictions</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getAirport()->getPredictions();
 * </code>
 */
class Predictions
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/airport/predictions</code> endpoints.
     * </p>
     */
    private ?OnTime $onTime;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->onTime = new OnTime($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/airport/predictions/on-time</code> endpoints.
     * </p>
     * @return OnTime
     */
    public function getOnTime(): OnTime
    {
        return $this->onTime;
    }
}
