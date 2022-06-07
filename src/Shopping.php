<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightOffers;

class Shopping
{
    /** @phpstan-ignore-next-line */
    private Amadeus $amadeus;

    private ?Availability $availability;
    private ?FlightOffers $flightOffers;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->availability = new Availability($amadeus);
        $this->flightOffers = new FlightOffers($amadeus);
    }

    /**
     * @return Availability|null
     */
    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    /**
     * @return FlightOffers|null
     */
    public function getFlightOffers(): ?FlightOffers
    {
        return $this->flightOffers;
    }

}
