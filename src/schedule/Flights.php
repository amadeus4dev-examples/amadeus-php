<?php

declare(strict_types=1);

namespace Amadeus\Schedule;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\DatedFlight;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v2/schedule/flights" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getSchedule()->getFlights();
 *
 */
class Flights
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
     * On-Demand Flight Status API:
     *
     * Retrieve a unique flight by search criteria..
     *
     *      $amadeus->getSchedule()->getFlights()->get(
     *          ["carrierCode"=>"IB", "flightNumber"=>532, "scheduledDepartureDate"=>"2022-09-23"]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/air/api-doc/on-demand-flight-status/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  DatedFlight[]       an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v2/schedule/flights',
            $params
        );

        return Resource::fromArray($response, DatedFlight::class);
    }
}
