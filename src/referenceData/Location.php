<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations/:location_id" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocation();
 *
 */
class Location
{
    private Amadeus $amadeus;
    private string $locationId;

    /**
     * @param Amadeus $amadeus
     * @param string $locationId
     */
    public function __construct(Amadeus $amadeus, string $locationId)
    {
        $this->amadeus = $amadeus;
        $this->locationId = $locationId;
    }

    /**
     * Airport and City Search API:
     *
     * Returns a specific airport or city based on its id.
     *
     *      $amadeus->getReferenceData()->getLocation("CMUC")->get();
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
     *
     * @return \Amadeus\Resources\Location  an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function get(): object
    {
        $response = $this->amadeus->getClient()->getWithOnlyPath(
            "/v1/reference-data/locations"."/".$this->locationId
        );

        return Resource::fromObject($response, \Amadeus\Resources\Location::class);
    }
}
