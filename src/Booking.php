<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Booking\FlightOrders;
use Amadeus\Booking\HotelBookings;

/**
 * A namespaced client for the
 * "/booking" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getBooking();
 *
 */
class Booking
{
    /**
     * A namespaced client for the
     * "/v1/booking/flightOrders" endpoints.
     */
    private FlightOrders  $flightOrders;

    /**
     * A namespaced client for the
     * "/v1/booking/hotelBookings" endpoints.
     */
    private HotelBookings $hotelBookings;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightOrders = new FlightOrders($amadeus);
        $this->hotelBookings = new HotelBookings($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/booking/flightOrders" endpoints.
     * @return FlightOrders
     */
    public function getFlightOrders(): FlightOrders
    {
        return $this->flightOrders;
    }

    /**
     * Get a namespaced client for the
     * "/v1/booking/hotelBookings" endpoints.
     * @return HotelBookings
     */
    public function getHotelBookings(): HotelBookings
    {
        return $this->hotelBookings;
    }
}
