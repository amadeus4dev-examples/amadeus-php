<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;
use Amadeus\Shopping\FlightOffers;

class Shopping
{
    public ?Availability $availability;
    public ?FlightOffers $flightOffers;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->availability = new Availability($client);
        $this->flightOffers = new FlightOffers($client);
    }
}
