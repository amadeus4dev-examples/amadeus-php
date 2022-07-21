<?php

declare(strict_types=1);

namespace Amadeus\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v2/shopping/flight-offers/prediction</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getFlightOffers()->getPrediction();
 * </code>
 */
class Prediction
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
     * ###Flight Choice Prediction API
     * <p>
     * This Machine Learning API is based on a prediction model that takes the response of a flight
     * search as input (Flight Offers Search) and predicts, for each itinerary, the probability to
     * be selected.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getFlightOffers()->getPrediction()->post($body);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-choice-prediction/api-reference
     *
     * @param string $body                  JSON body of flight offers as String to price
     * @return FlightOffer[]                an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function post(string $body): array
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v2/shopping/flight-offers/prediction',
            $body
        );

        return Resource::fromArray($response, FlightOffer::class);
    }

    /**
     * ###Flight Choice Prediction API
     * <p>
     * This Machine Learning API is based on a prediction model that takes the response of a flight
     * search as input (Flight Offers Search) and predicts, for each itinerary, the probability to
     * be selected.
     * </p>
     *
     * <code>
     *  $flightOffers = $amadeus->getShopping()->getFlightOffers()->get($params);
     *  $amadeus->getShopping()->getFlightOffers()->getPrediction()->postWithFlightOffers($flightOffers);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-choice-prediction/api-reference
     * @param array $flightOffers           Lists of flight offers as FlightOffer[]
     * @return FlightOffer[]                an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function postWithFlightOffers(array $flightOffers): array
    {
        $flightOffersArray = array();
        foreach ($flightOffers as $flightOffer) {
            $flightOffersArray[] = json_decode((string)$flightOffer);
        }

        // Prepare JSON object
        $flightOffersInput = (object)[
            "data" => $flightOffersArray
        ];

        $body = Resource::toString(get_object_vars($flightOffersInput));

        return $this->post($body);
    }
}
