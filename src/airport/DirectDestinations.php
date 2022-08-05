<?php

declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Destination;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/airport/direct-destinations" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getAirport()->getDirectDestinations();
 *
 */
class DirectDestinations
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
     * Airport Routes API:
     *
     * Find all destinations served by a given airport.
     *
     *      $amadeus->getAirport()->getDirectDestinations()->get(
     *          ["departureAirportCode" => "MAD", "max" => 2]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  Destination[]       an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/airport/direct-destinations',
            $params
        );

        return Resource::fromArray($response, Destination::class);
    }
}
