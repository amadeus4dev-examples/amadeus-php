<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Hotel;
use Amadeus\ReferenceData\Locations\Hotels;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocations();
 * </code>
 */
class Locations
{
    private Amadeus $amadeus;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations/hotels</code> endpoints.
     * </p>
     */
    private Hotels $hotels;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/reference-data/locations/hotel</code> endpoints.
     * </p>
     */
    private Hotel $hotel;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->hotels = new Hotels($amadeus);
        $this->hotel = new Hotel($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/hotels</code> endpoints.
     * </p>
     * @return Hotels
     */
    public function getHotels(): Hotels
    {
        return $this->hotels;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/reference-data/locations/hotel</code> endpoints.
     * </p>
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * ###Airport and City Search API
     * <p>
     *    Returns a list of airports and cities matching a given keyword.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getLocations()->get(
     *      ["keyword" => "PAR", "subType" => "CITY"]
     *  );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
     *
     * @param array $query          the parameters to send to the API
     * @return Location[]           an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function get(array $query): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/reference-data/locations',
            $query
        );

        return Resource::fromArray($response, Location::class);
    }
}
