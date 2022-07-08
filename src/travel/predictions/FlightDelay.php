<?php


declare(strict_types=1);

namespace Amadeus\Travel\Predictions;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\DelayPrediction;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/travel/predictions/flight-delay</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getTravel()->getPredictions()->getFlightDelay();
 * </code>
 */
class FlightDelay
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
     * ###Flight Delay Prediction API
     * <p>
     *    Return the delay segment where the flight is likely to lay.
     * </p>
     *
     * <code>
     * $amadeus->getTravel()->getPredictions()->getFlightDelay()->get([
     *      "originLocationCode"=>"NCE", "destinationLocationCode"=>"ATH",
     *      "departureDate"=>"2022-10-06", "departureTime"=>"18:40:00",
     *      "arrivalDate"=>"2022-10-06", "arrivalTime"=>"22:05:00",
     *      "aircraftCode"=>"32N", "carrierCode"=>"A3",
     *      "flightNumber"=>"691", "duration"=>"PT2H25M"
     *  ]);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-delay-prediction/api-reference
     *
     * @param array $params the parameters to send to the API
     * @return  DelayPrediction[]       an API resource
     * @throws  ResponseException       when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/travel/predictions/flight-delay',
            $params
        );

        return Resource::fromArray($response, DelayPrediction::class);
    }
}
