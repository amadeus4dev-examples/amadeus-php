<?php

declare(strict_types=1);

namespace Amadeus\Airport\Predictions;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\OnTimePrediction;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/airport/predictions/on-time</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getAirport()->getPredictiions()->getOnTime();
 * </code>
 */
class OnTime
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
     * ###Airport On-Time Performance API
     * <p>
     *    Returns a percentage of on-time flight departures from a given airport.
     * </p>
     *
     * <code>
     *  $$amadeus->getAirport()->getPredictions()->getOnTime()->get(
     *      ["airportCode" => "NCE", "date" => 2022-11-01]);
     *  );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-on-time-performance/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  OnTimePrediction       an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): object
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/airport/predictions/on-time',
            $params
        );

        return Resource::fromObject($response, OnTimePrediction::class);
    }
}
