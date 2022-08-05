<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Airlines;
use Amadeus\ReferenceData\Location;
use Amadeus\ReferenceData\Locations;
use Amadeus\ReferenceData\RecommendedLocations;

/**
 * A namespaced client for the
 * "/referenceData" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping();
 *
 */
class ReferenceData
{
    private Amadeus $amadeus;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations" endpoints.
     */
    private Locations $locations;

    /**
     * A namespaced client for the
     * "/v1/reference-data/airlines" endpoints.
     */
    private Airlines $airlines;

    /**
     * A namespaced client for the
     * "/v1/reference-data/recommended-locations" endpoints.
     */
    private RecommendedLocations $recommendedlocations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->locations = new Locations($amadeus);
        $this->airlines = new Airlines($amadeus);
        $this->recommendedlocations = new RecommendedLocations($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations" endpoints.
     * @return Locations
     */
    public function getLocations(): Locations
    {
        return $this->locations;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/:location_id" endpoints.
     * @param string $locationId
     * @return Location
     */
    public function getLocation(string $locationId): Location
    {
        return new Location($this->amadeus, $locationId);
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/airlines" endpoints.
     * @return Airlines
     */
    public function getAirlines(): Airlines
    {
        return $this->airlines;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/recommended-locations" endpoints.
     * @return RecommendedLocations
     */
    public function getRecommendedLocations(): RecommendedLocations
    {
        return $this->recommendedlocations;
    }
}
