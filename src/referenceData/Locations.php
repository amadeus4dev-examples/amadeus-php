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
 * Airport and City Search API
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
 */
class Locations
{
    private Amadeus $amadeus;

    private Hotels $hotels;

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
     * @return Hotels
     */
    public function getHotels(): Hotels
    {
        return $this->hotels;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * @param array $query
     * @return Location[]
     * @throws ResponseException
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
