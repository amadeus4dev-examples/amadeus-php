<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightOffers;

class Shopping
{
    /** @phpstan-ignore-next-line */
    private Amadeus $amadeus;

    public ?Availability $availability;
    public ?FlightOffers $flightOffers;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->availability = new Availability($amadeus);
        $this->flightOffers = new FlightOffers($amadeus);
    }
}
