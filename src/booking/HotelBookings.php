<?php

declare(strict_types=1);

namespace Amadeus\Booking;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\HotelBookingLight;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/booking/hotel-bookings</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getBooking()->getHotelBookings();
 * </code>
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
     * ###Hotel Booking API
     * <p>
     *    The Hotel Booking API allows you to perform hotel booking.
     * </p>
     *
     * <code>
     *  $amadeus->getBooking()->getHotelBookings()->post($body);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference
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
