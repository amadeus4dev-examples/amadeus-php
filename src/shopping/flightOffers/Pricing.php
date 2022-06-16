<?php

declare(strict_types=1);

namespace Amadeus\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOfferPricingOutput;
use Amadeus\Resources\Resource;

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
        $response = $this->amadeus->getClient()->postWithStringBodyAndArrayParams(
            '/v1/shopping/flight-offers/pricing',
            $body,
            $params
        );

        return Resource::fromObject($response, FlightOfferPricingOutput::class);
    }

    /**
     * @return FlightOfferPricingOutput
     * @throws ResponseException
     */
    public function postWithFlightOfferPricingInput(array $flightOffers, ?array $params = null): object
    {
        $flightOffersArray = array();
        foreach ($flightOffers as $flightOffer) {
            $flightOffersArray[] = json_decode((string)$flightOffer);
        }
        $flightOfferPricingInput = (object)[
            "data" => (object)[
                "type" => "flight-offers-pricing",
                "flightOffers" => $flightOffersArray
            ]
        ];
        $body = json_encode($flightOfferPricingInput);

        return $this->post($body, $params);
    }
}
