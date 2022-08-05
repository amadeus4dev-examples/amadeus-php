<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations/airports" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocations()->getAirports();
 *
 */
class Airports
{
    private Amadeus $amadeus;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Airport Nearest Relevant API:
     *
     * Returns a list of relevant airports near to a given point.
     *
     *      $amadeus->getReferenceData()->getLocations()->getAirports()->get(
     *          ["latitude"=>51.57285, "longitude"=>-0.44161, "radius"=>500]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/airport-nearest-relevant/api-reference
     *
     * @param  array $params        the parameters to send to the API
     * @return Location[]           an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/reference-data/locations/airports',
            $params
        );

        return Resource::fromArray($response, Location::class);
    }
}
