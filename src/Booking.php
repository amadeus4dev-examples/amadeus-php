<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Booking\FlightOrders;
use Amadeus\Booking\HotelBookings;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/booking</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getBooking();
 * </code>
 */
class Booking
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/booking/flightOrders</code> endpoints.
     * </p>
     */
    private ?FlightOrders  $flightOrders;

    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/booking/hotelBookings</code> endpoints.
     * </p>
     */
    private ?HotelBookings $hotelBookings;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightOrders = new FlightOrders($amadeus);
        $this->hotelBookings = new HotelBookings($amadeus);
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/booking/flightOrders</code> endpoints.
     * </p>
     * @return FlightOrders|null
     */
    public function getFlightOrders(): ?FlightOrders
    {
        return $this->flightOrders;
    }

    /**
     * <p>
     *   Get a namespaced client for the
     *   <code>/v1/booking/hotelBookings</code> endpoints.
     * </p>
     * @return HotelBookings|null
     */
    public function getHotelBookings(): ?HotelBookings
    {
        return $this->hotelBookings;
    }
}
