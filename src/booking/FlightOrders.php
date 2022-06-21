<?php

declare(strict_types=1);

namespace Amadeus\Booking;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/booking/flight-orders</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getBooking()->getFlightOrders();
 * </code>
 */
class FlightOrders
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
     * ###Flight Create Orders API
     * <p>
     *    The Flight Create Orders API allows you to perform flight booking.
     * </p>
     *
     * <code>
     *  $amadeus->getBooking()->getFlightOrders()->post($body);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
     *
     * @param  string $body         the parameters to send to the API as a String
     * @return FlightOrder          an API resource
     * @throws ResponseException    when an exception occurs
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
     * ###Flight Create Orders API
     * <p>
     *    The Flight Create Orders API allows you to perform flight booking.
     * </p>
     *
     * <code>
     *  $amadeus->getBooking()->getFlightOrders()->post($fightOffer, $travelers);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
     *
     * @param array $flightOffers   Lists of flight offers as FlightOffer[]
     * @param array $travelers      List of travelers as TravelerElement[]
     * @return FlightOrder          an API resource
     * @throws ResponseException    when an exception occurs
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

        // Prepare the post JSON body
        $flightOrderQuery = (object)[
            "data" => (object)[
                "type" => "flight-offers-pricing",
                "flightOffers" => $flightOffersArray,
                "travelers" => $travelersArray
            ]
        ];

        $body = Resource::toString(get_object_vars($flightOrderQuery));

        return $this->post($body);
    }
}
