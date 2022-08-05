<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Travel\Predictions;

/**
 * A namespaced client for the
 * "/travel" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getTravel();
 *
 */
class Travel
{
    /**
     * A namespaced client for the
     * "/v1/travel/predictions" endpoints.
     */
    private Predictions $predictions;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->predictions = new Predictions($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/travel/predictions" endpoints.
     * @return Predictions
     */
    public function getPredictions(): Predictions
    {
        return $this->predictions;
    }
}
