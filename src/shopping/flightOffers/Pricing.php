<?php

declare(strict_types=1);

namespace Amadeus\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOfferPricingOutput;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/shopping/flight-offers/pricing</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getShopping()->getFlightOffers()->getPricing();
 * </code>
 */
class Pricing
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
     * ###Flight Offers Price API
     * <p>
     *  The Flight Offers Price API allows the user to get or confirm the price of a flight
     *  and obtain information about taxes and fees to be applied to the entire journey.
     *  It is usually used after the Flight Offers Search API.
     *  It also retrieves ancillary information and the payment information details.
     * </p>
     *
     * <code>
     *  $amadeus->getShopping()->getFlightOffers()->getPricing()->post($body, $params); //$params is optional
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference
     *
     * @param string $body                  JSON body of flight offers as String to price
     * @param array|null $params            (optional)URL parameters such as include or forceClass
     * @return FlightOfferPricingOutput     an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function post(string $body, ?array $params = null): object
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v1/shopping/flight-offers/pricing',
            $body,
            $params
        );

        return Resource::fromObject($response, FlightOfferPricingOutput::class);
    }


    /**
     * ###Flight Offers Price API

     * <p>
     *  The Flight Offers Price API allows the user to get or confirm the price of a flight
     *  and obtain information about taxes and fees to be applied to the entire journey.
     *  It is usually used after the Flight Offers Search API.
     *  It also retrieves ancillary information and the payment information details.
     * </p>
     *
     * <code>
     *  // $payments, $travelers, $params are optional
     *  $amadeus->getShopping()->getFlightOffers()->getPricing()->post($flightOffers, $payments, $travelers $params);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference
     *
     * @param array $flightOffers           Lists of flight offers as FlightOffer[]
     * @param array|null $payments          (optional) Lists of payments as FlightPayment[]
     * @param array|null $travelers         (optional) Lists of travelers as TravelerElement[]
     * @param array|null $params            (optional) URL parameters such as include or forceClass
     * @return FlightOfferPricingOutput     an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function postWithFlightOffers(
        array $flightOffers,
        ?array $payments = null,
        ?array $travelers = null,
        ?array $params = null
    ): object {
        $flightOffersArray = array();
        foreach ($flightOffers as $flightOffer) {
            $flightOffersArray[] = json_decode((string)$flightOffer);
        }

        if ($payments != null) {
            $paymentsArray = array();
            foreach ($payments as $payment) {
                $paymentsArray[] = json_decode((string)$payment);
            }
        } else {
            $paymentsArray = null;
        }


        if ($travelers != null) {
            $travelersArray = array();
            foreach ($travelers as $traveler) {
                $travelersArray[] = json_decode((string)$traveler);
            }
        } else {
            $travelersArray = null;
        }

        // Prepare JSON object
        $flightPricingQuery = (object)[
            "data" => (object)[
                "type" => "flight-offers-pricing",
                "flightOffers" => $flightOffersArray,
                "payments" => $paymentsArray,
                "travelers" => $travelersArray
            ]
        ];

        $body = Resource::toString(get_object_vars($flightPricingQuery));

        return $this->post($body, $params);
    }
}
