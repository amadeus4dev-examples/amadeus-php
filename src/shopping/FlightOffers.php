<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;

class FlightOffers
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
     * @param array $params
     * @return FlightOffer[]
     * @throws ResponseException
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->client->getWithArrayParams(
            '/v2/shopping/flight-offers',
            $params
        );

        return Resource::fromArray($response, FlightOffer::class);
    }

    /**
     * @param string $body
     * @return array
     * @throws ResponseException
     */
    public function post(string $body): array
    {
        $response = $this->amadeus->client->postWithStringBody(
            '/v2/shopping/flight-offers',
            $body
        );

        return Resource::fromArray($response, FlightOffer::class);
    }
}
