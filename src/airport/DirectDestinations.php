<?php

declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Destination;
use Amadeus\Resources\Resource;

/**
 * Airport Routes API
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
 */
class DirectDestinations
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
     * @param array $query
     * @return Destination[]
     * @throws ResponseException
     */
    public function get(array $query): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/airport/direct-destinations',
            $query
        );

        return Resource::fromArray($response, Destination::class);
    }
}
