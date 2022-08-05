<?php

declare(strict_types=1);

namespace Amadeus\Booking;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\HotelBookingLight;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/booking/hotel-bookings" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getBooking()->getHotelBookings();
 *
 */
class HotelBookings
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
     * Hotel Booking API:
     *
     * The Hotel Booking API allows you to perform hotel booking.
     *
     *      $amadeus->getBooking()->getHotelBookings()->post($body);
     *
     * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference
     *
     * @param  string $body         the parameters to send to the API as a String
     * @return HotelBookingLight[]  an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function post(string $body): array
    {
        $response = $this->amadeus->getClient()->postWithStringBody(
            '/v1/booking/hotel-bookings',
            $body
        );

        return Resource::fromArray($response, HotelBookingLight::class);
    }
}
