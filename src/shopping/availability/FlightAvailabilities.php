<?php

declare(strict_types=1);

namespace Amadeus\Shopping\Availability;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\Resource;

class FlightAvailabilities
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
     * @param string $body
     * @return FlightAvailability[]
     * @throws ResponseException
     */
    public function post(string $body): array
    {
        $response = $this->client->postWithStringBody(
            '/v1/shopping/availability/flight-availabilities',
            $body
        );

        return Resource::fromArray($response, FlightAvailability::class);
    }
}
