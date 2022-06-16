<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Booking\FlightOrders;

class Booking
{
    private ?FlightOrders  $flightOrders;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightOrders = new FlightOrders($amadeus);
    }

    /**
     * @return FlightOrders|null
     */
    public function getFlightOrders(): ?FlightOrders
    {
        return $this->flightOrders;
    }
}
