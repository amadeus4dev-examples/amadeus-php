<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Airline;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/airlines</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getAirlines();
 * </code>
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
     * ###Airline Code Lookup API
     * <p>
     *    Returns a list of Airlines information.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getAirlines()->get(
     *      ["airlineCodes" => "BA"]
     *  );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airline-code-lookup/api-reference
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
