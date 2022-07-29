<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Airlines;
use Amadeus\ReferenceData\Location;
use Amadeus\ReferenceData\Locations;
use Amadeus\ReferenceData\RecommendedLocations;

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
    private Locations $locations;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/airlines</code> endpoints.
     * </p>
     */
    private Airlines $airlines;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/recommended-locations</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations</code> endpoints.
     * </p>
     * @return Locations
     */
    public function getLocations(): Locations
    {
        return $this->locations;
    }


    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/:location_id</code> endpoints.
     * </p>
     * @param string $locationId
     * @return Location
     */
    public function getLocation(string $locationId): Location
    {
        return new Location($this->amadeus, $locationId);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/airlines</code> endpoints.
     * </p>
     * @return Airlines
     */
    public function getAirlines(): Airlines
    {
        return $this->airlines;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/recommended-locations</code> endpoints.
     * </p>
     * @return RecommendedLocations
     */
    public function getRecommendedLocations(): RecommendedLocations
    {
        return $this->recommendedlocations;
    }
}
