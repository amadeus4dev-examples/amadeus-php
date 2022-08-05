<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightDate;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/shopping/flight-dates" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getFlightDates();
 *
 */
class FlightDates
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
     * Flight Cheapest Dates Search API:
     *
     * Find the cheapest flight dates from an origin to a destination.
     *
     *      $amadeus->getShopping()->getFlightDates()->get(
     *          array(
     *                  "origin" => "MAD",
     *                  "destination" => "LON"
     *          )
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-cheapest-date-search/api-reference
     *
     * @param array $params         the parameters to send to the API
     * @return FlightDate[]         an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/shopping/flight-dates",
            $params
        );

        return Resource::fromArray($response, FlightDate::class);
    }
}
