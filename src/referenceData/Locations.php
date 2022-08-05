<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Airports;
use Amadeus\ReferenceData\Locations\Hotel;
use Amadeus\ReferenceData\Locations\Hotels;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocations();
 *
 */
class Locations
{
    private Amadeus $amadeus;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/hotels" endpoints.
     */
    private Hotels $hotels;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/hotel" endpoints.
     */
    private Hotel $hotel;

    /**
     * A namespaced client for the
     * "/v1/reference-data/locations/airports" endpoints.
     */
    private Airports $airports;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->hotels = new Hotels($amadeus);
        $this->hotel = new Hotel($amadeus);
        $this->airports = new Airports($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/hotels" endpoints.
     * @return Hotels
     */
    public function getHotels(): Hotels
    {
        return $this->hotels;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/hotel" endpoints.
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * Get a namespaced client for the
     * "/v1/reference-data/locations/airports" endpoints.
     * @return Airports
     */
    public function getAirports(): Airports
    {
        return $this->airports;
    }

    /**
     * Airport and City Search API
     *
     * Returns a list of airports and cities matching a given keyword.
     *
     *      $amadeus->getReferenceData()->getLocations()->get(
     *          ["keyword" => "PAR", "subType" => "CITY"]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
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
