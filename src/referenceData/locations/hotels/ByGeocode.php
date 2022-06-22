<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Hotel;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations/hotels/by-geocode</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocations()->getHotels()->getByGeocode();
 * </code>
 */
class ByGeocode
{
    private Amadeus $amadeus;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * ###Hotel List API
     * <p>
     *    Returns a list of hotels result of the search using GeoCode.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getLocations()->getHotels()->getByGeocode->get(
     *      ["latitude" => "41.397158", "longitude" => "2.31836"]
     *  );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
     *
     * @param array $params         the parameters to send to the API
     * @return Hotel[]              an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/reference-data/locations/hotels/by-geocode",
            $params
        );

        return Resource::fromArray($response, Hotel::class);
    }
}
