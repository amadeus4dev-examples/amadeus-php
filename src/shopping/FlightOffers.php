<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\FlightOffers\Pricing;

/**
 * Flight Offers Search API
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
 */
class FlightOffers
{
    private Amadeus $amadeus;

    private Pricing $pricing;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->pricing = new Pricing($amadeus);
    }

    /**
     * @return Pricing
     */
    public function getPricing(): Pricing
    {
        return $this->pricing;
    }

    /**
     * @param array $params
     * @return FlightOffer[]
     * @throws ResponseException
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
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
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v2/shopping/flight-offers',
            $body
        );

        return Resource::fromArray($response, FlightOffer::class);
    }
}
