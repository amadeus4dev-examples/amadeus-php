<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations/:location_id</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocation();
 * </code>
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
     * ###Airport and City Search API
     * <p>
     *    Returns a specific airport or city based on its id.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getLocation("CMUC")->get();
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
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
