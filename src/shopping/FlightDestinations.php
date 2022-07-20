<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightDestination;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/shopping/flight-destinations</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getFlightDestinations();
 * </code>
 */
class FlightDestinations
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
     * ###Flight Inspiration Search API
     * <p>
     *   Find the cheapest destinations where you can fly to.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getFlightDestination()->get(["origin"=>"MUC"]);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-inspiration-search/api-reference
     *
     * @param array $params             the parameters to send to the API
     * @return FlightDestination[]      an API resource
     * @throws ResponseException        when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/shopping/flight-destinations",
            $params
        );

        return Resource::fromArray($response, FlightDestination::class);
    }
}
