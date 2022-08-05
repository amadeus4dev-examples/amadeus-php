<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\FlightOffers\Prediction;
use Amadeus\Shopping\FlightOffers\Pricing;

/**
 * A namespaced client for the
 * "/v2/shopping/flight-offers" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getFlightOffers();
 *
 */
class FlightOffers
{
    private Amadeus $amadeus;

    /**
     * A namespaced client for the
     * "/v1/shopping/flight-offers/pricing" endpoints.
     */
    private Pricing $pricing;

    /**
     * A namespaced client for the
     * "/v2/shopping/flight-offers/prediction" endpoints.
     */
    private Prediction $prediction;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->pricing = new Pricing($amadeus);
        $this->prediction = new Prediction($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/shopping/flight-offers/pricing" endpoints.
     * @return Pricing
     */
    public function getPricing(): Pricing
    {
        return $this->pricing;
    }

    /**
     * Get a namespaced client for the
     * "/v2/shopping/flight-offers/prediction" endpoints.
     * @return Prediction
     */
    public function getPrediction(): Prediction
    {
        return $this->prediction;
    }

    /**
     * Flight Offers Search API:
     *
     * The Flight Offers Search API allows to get the cheapest flight recommendations on a given journey.
     * It provides a list of flight recommendations and fares from a given origin,
     * for a given date and for a given list of passengers.
     * Additional information such as bag allowance,
     * first ancillary bag prices or fare details are also provided.
     *
     *      $flightOffers = $amadeus->getShopping()->getFlightOffers()->get(
     *          array(
     *              "originLocationCode" => "LON",
     *              "destinationLocationCode" => "NYC",
     *              "departureDate" => "2022-07-06",
     *              "adults" => "1",
     *              "max" => 20
     *          )
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
     *
     * @param array $params         the parameters to send to the API
     * @return FlightOffer[]        an API resource
     * @throws ResponseException    when an exception occurs
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
     * Flight Offers Search API:
     *
     * The Flight Offers Search API allows to get the cheapest flight recommendations on a given journey.
     * It provides a list of flight recommendations and fares from a given origin,
     * for a given date and for a given list of passengers.
     * Additional information such as bag allowance,
     * first ancillary bag prices or fare details are also provided.
     *
     *      $flightOffers = $amadeus->getShopping()->getFlightOffers()->post($body);
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
     *
     * @param string $body          the parameters to send to the API as a String
     * @return array                an API resource
     * @throws ResponseException    when an exception occurs
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
