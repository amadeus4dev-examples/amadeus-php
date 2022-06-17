<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Booking\FlightOrders;
use Amadeus\Booking\HotelBookings;

class Booking
{
    private ?FlightOrders  $flightOrders;
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
     * @return FlightOrders|null
     */
    public function getFlightOrders(): ?FlightOrders
    {
        return $this->flightOrders;
    }

    /**
     * @return HotelBookings|null
     */
    public function getHotelBookings(): ?HotelBookings
    {
        return $this->hotelBookings;
    }
}
