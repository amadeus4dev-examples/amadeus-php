<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\ReferenceData\Locations\Hotels\ByCity;
use Amadeus\ReferenceData\Locations\Hotels\ByGeocode;
use Amadeus\ReferenceData\Locations\Hotels\ByHotels;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations/hotels</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocations()->getHotels();
 * </code>
 */
class Hotels
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-city</code> endpoints.
     * </p>
     */
    private ByCity $byCity;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-geocode</code> endpoints.
     * </p>
     */
    private ByGeocode $byGeocode;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-hotels</code> endpoints.
     * </p>
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-city</code> endpoints.
     * </p>
     * @return ByCity
     */
    public function getByCity(): ByCity
    {
        return $this->byCity;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-geocode</code> endpoints.
     * </p>
     * @return ByGeocode
     */
    public function getByGeocode(): ByGeocode
    {
        return $this->byGeocode;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/hotels/by-hotels</code> endpoints.
     * </p>
     * @return ByHotels
     */
    public function getByHotels(): ByHotels
    {
        return $this->byHotels;
    }
}
