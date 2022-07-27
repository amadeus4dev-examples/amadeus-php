<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Airport\Predictions;
use Amadeus\Airport\DirectDestinations;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/airport</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getAirport();
 * </code>
 */
class Airport
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/airport/direct-destinations</code> endpoints.
     * </p>
     */
    private ?DirectDestinations $directDestinations;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/airport/predictions</code> endpoints.
     * </p>
     */
    private ?Predictions $predictions;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->directDestinations = new DirectDestinations($amadeus);
        $this->predictions = new Predictions($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/airport/direct-destinations</code> endpoints.
     * </p>
     * @return DirectDestinations|null
     */
    public function getDirectDestinations(): ?DirectDestinations
    {
        return $this->directDestinations;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/airport/predictions</code> endpoints.
     * </p>
     * @return Predictions|null
     */
    public function getPredictions(): ?Predictions
    {
        return $this->predictions;
    }
}
