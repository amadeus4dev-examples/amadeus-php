<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

class Locations
{
    private Amadeus $client;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $query
     * @return Location[]
     * @throws ResponseException
     */
    public function get(array $query): array
    {
        $response = $this->client->getWithArrayParams(
            '/v1/reference-data/locations',
            $query
        );

        return Resource::fromArray($response, Location::class);
    }
}
