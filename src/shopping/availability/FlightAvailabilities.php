<?php

declare(strict_types=1);

namespace Amadeus\Shopping\Availability;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/shopping/availability/flight-availabilities" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getAvailability()->getFlightAvailabilities();
 *
 */
class FlightAvailabilities
{
    private Amadeus $amadeus;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Flight Availabilities Search API:
     *
     * The Amadeus Flight Availability API provides a list of flights with seats for sale,
     * and the quantity of seats available in different fare classes on a given itinerary.
     * Additional information such as carrier and aircraft information,
     * the departure and arrival terminals, schedule, and route are also provided.
     *
     *      $amadeus->getShopping()->getAvailability()->getFlightAvailabilities()->post(body);
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
     *
     * @param string $body              the parameters to send to the API as a JsonObject
     * @return FlightAvailability[]     an API resource
     * @throws ResponseException        when an exception occurs
     */
    public function post(string $body): array
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v1/shopping/availability/flight-availabilities',
            $body
        );

        return Resource::fromArray($response, FlightAvailability::class);
    }
}
