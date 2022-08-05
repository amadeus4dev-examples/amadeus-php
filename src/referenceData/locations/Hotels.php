<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\ReferenceData\Locations\Hotels\ByCity;
use Amadeus\ReferenceData\Locations\Hotels\ByGeocode;
use Amadeus\ReferenceData\Locations\Hotels\ByHotels;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations/hotels" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocations()->getHotels();
 *
 */
class Hotels
{
    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/hotels/by-city" endpoints.
     */
    private ByCity $byCity;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/hotels/by-geocode" endpoints.
     */
    private ByGeocode $byGeocode;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/hotels/by-hotels" endpoints.
     */
    private ByHotels $byHotels;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->byCity = new ByCity($amadeus);
        $this->byGeocode = new ByGeocode($amadeus);
        $this->byHotels = new ByHotels($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/hotels/by-city" endpoints.
     * @return ByCity
     */
    public function getByCity(): ByCity
    {
        return $this->byCity;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/hotels/by-geocode" endpoints.
     * @return ByGeocode
     */
    public function getByGeocode(): ByGeocode
    {
        return $this->byGeocode;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/hotels/by-hotels" endpoints.
     * @return ByHotels
     */
    public function getByHotels(): ByHotels
    {
        return $this->byHotels;
    }
}
