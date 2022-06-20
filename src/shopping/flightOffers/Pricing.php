<?php

declare(strict_types=1);

namespace Amadeus\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOfferPricingOutput;
use Amadeus\Resources\Resource;

/**
 * Flight Offers Price API
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference
 */
class Pricing
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
     * @param string $body
     * @param array|null $params
     * @return FlightOfferPricingOutput
     * @throws ResponseException
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
     * @param array $flightOffers
     * @param array|null $payments
     * @param array|null $travelers
     * @param array|null $params
     * @return FlightOfferPricingOutput
     * @throws ResponseException
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
