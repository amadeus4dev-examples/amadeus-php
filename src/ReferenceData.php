<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Locations;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/referenceData</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping();
 * </code>
 */
class ReferenceData
{
    private ?Locations $locations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->locations = new Locations($amadeus);
    }

    /**
     * @return Locations|null
     */
    public function getLocations(): ?Locations
    {
        return $this->locations;
    }
}
