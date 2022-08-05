<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Airline;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/airlines" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getAirlines();
 *
 */
class Airlines
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
     * Airline Code Lookup API:
     *
     * Returns a list of Airlines information.
     *
     *      $amadeus->getReferenceData()->getAirlines()->get(
     *          ["airlineCodes" => "BA"]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/airline-code-lookup/api-reference
     *
     * @param array $params
     * @return Airline[]           an API resource
     * @throws ResponseException when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/reference-data/airlines',
            $params
        );

        return Resource::fromArray($response, Airline::class);
    }
}
