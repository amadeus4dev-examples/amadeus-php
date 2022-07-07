<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations/airports</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocations()->getAirports();
 * </code>
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
     * ###Airport Nearest Relevant API
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-nearest-relevant/api-reference
     *
     * @param array $params
     * @return Location[]
     * @throws ResponseException
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
