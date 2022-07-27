<?php

declare(strict_types=1);

namespace Amadeus;

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
    private DirectDestinations $directDestinations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->directDestinations = new DirectDestinations($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/airport/direct-destinations</code> endpoints.
     * </p>
     * @return DirectDestinations
     */
    public function getDirectDestinations(): DirectDestinations
    {
        return $this->directDestinations;
    }
}
