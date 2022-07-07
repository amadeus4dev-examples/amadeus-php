<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Travel\Predictions;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/travel</code> endpoints.
 * </p>
 *
 * <p>
@@ -18,36 +18,36 @@
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getTravel();
 * </code>
 */
class Travel
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/travel/predictions</code> endpoints.
     * </p>
     */
    private ?Predictions $predictions;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->predictions = new Predictions($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/travel/predictions</code> endpoints.
     * </p>
     * @return Predictions|null
     */
    public function getPredictions(): ?Predictions
    {
        return $this->predictions;
    }
}