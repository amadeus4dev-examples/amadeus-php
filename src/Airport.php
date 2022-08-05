<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Airport\Predictions;
use Amadeus\Airport\DirectDestinations;

/**
 * A namespaced client for the
 * "/airport" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getAirport();
 *
 */
class Airport
{
    /**
     * A namespaced client for the
     * "/v1/airport/direct-destinations" endpoints.
     */
    private DirectDestinations $directDestinations;

    /**
     * A namespaced client for the
     * "/v1/airport/predictions" endpoints.
     */
    private Predictions $predictions;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->directDestinations = new DirectDestinations($amadeus);
        $this->predictions = new Predictions($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/airport/direct-destinations" endpoints.
     * @return DirectDestinations
     */
    public function getDirectDestinations(): DirectDestinations
    {
        return $this->directDestinations;
    }

    /**
     * Get a namespaced client for the
     * "/v1/airport/predictions" endpoints.
     * @return Predictions
     */
    public function getPredictions(): Predictions
    {
        return $this->predictions;
    }
}
