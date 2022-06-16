<?php

declare(strict_types=1);

namespace Amadeus\Booking;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\Resource;

class FlightOrders
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
     * @return FlightOrder
     * @throws ResponseException
     */
    public function post(string $body): object
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v1/booking/flight-orders',
            $body
        );

        return Resource::fromObject($response, FlightOrder::class);
    }

    /**
     * @param array $flightOffers
     * @param array $travelers
     * @return FlightOrder
     * @throws ResponseException
     */
    public function postWithFlightOffersAndTravelers(
        array $flightOffers,
        array $travelers
    ): object {
        $flightOffersArray = array();
        foreach ($flightOffers as $flightOffer) {
            $flightOffersArray[] = json_decode((string)$flightOffer);
        }

        $travelersArray = array();
        foreach ($travelers as $traveler) {
            $travelersArray[] = json_decode((string)$traveler);
        }

        $flightOrderQuery = (object)[
            "data" => (object)[
                "type" => "flight-offers-pricing",
                "flightOffers" => $flightOffersArray,
                "travelers" => $travelersArray
            ]
        ];
        $body = json_encode($flightOrderQuery);

        return $this->post($body);
    }
}
