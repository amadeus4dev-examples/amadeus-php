<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\FlightOffers\Pricing;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v2/shopping/flight-offers</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getFlightOffers();
 * </code>
 */
class FlightOffers
{
    private Amadeus $amadeus;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/shopping/flight-offers/pricing</code> endpoints.
     * </p>
     */
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
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/shopping/flight-offers/pricing</code> endpoints.
     * </p>
     * @return Pricing
     */
    public function getPricing(): Pricing
    {
        return $this->pricing;
    }

    /**
     * ###Flight Offers Search API
     * <p>
     *  The Flight Offers Search API allows to get the cheapest flight recommendations on a given journey.
     *  It provides a list of flight recommendations and fares from a given origin,
     *  for a given date and for a given list of passengers.
     *  Additional information such as bag allowance,
     *  first ancillary bag prices or fare details are also provided.
     * </p>
     *
     * <code>
     *  $flightOffers = $amadeus->getShopping()->getFlightOffers()->get(
     *      array(
     *          "originLocationCode" => "LON",
     *          "destinationLocationCode" => "NYC",
     *          "departureDate" => "2022-07-06",
     *          "adults" => "1",
     *          "max" => 20
     *      )
     * );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
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
     * ###Flight Offers Search API
     * <p>
     *  The Flight Offers Search API allows to get the cheapest flight recommendations on a given journey.
     *  It provides a list of flight recommendations and fares from a given origin,
     *  for a given date and for a given list of passengers.
     *  Additional information such as bag allowance,
     *  first ancillary bag prices or fare details are also provided.
     * </p>
     *
     * <code>
     *  $flightOffers = $amadeus->getShopping()->getFlightOffers()->post($body);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
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
