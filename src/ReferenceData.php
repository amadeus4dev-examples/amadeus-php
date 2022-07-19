<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Airlines;
use Amadeus\ReferenceData\Location;
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
    private Amadeus $amadeus;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations</code> endpoints.
     * </p>
     */
    private ?Locations $locations;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/airlines</code> endpoints.
     * </p>
     */
    private ?Airlines $airlines;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->locations = new Locations($amadeus);
        $this->airlines = new Airlines($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations</code> endpoints.
     * </p>
     * @return Locations|null
     */
    public function getLocations(): ?Locations
    {
        return $this->locations;
    }


    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/:location_id</code> endpoints.
     * </p>
     * @param string $locationId
     * @return Location|null
     */
    public function getLocation(string $locationId): ?Location
    {
        return new Location($this->amadeus, $locationId);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/airlines</code> endpoints.
     * </p>
     * @return Airlines|null
     */
    public function getAirlines(): ?Airlines
    {
        return $this->airlines;
    }
}
