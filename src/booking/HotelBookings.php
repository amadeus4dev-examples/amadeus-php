<?php

declare(strict_types=1);

namespace Amadeus\Booking;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOrder;
use Amadeus\Resources\HotelBookingLight;
use Amadeus\Resources\Resource;

/**
 * Hotel Booking API
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference
 */
class HotelBookings
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
     * @return HotelBookingLight[]
     * @throws ResponseException
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
