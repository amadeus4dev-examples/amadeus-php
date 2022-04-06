<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Shopping\Availability\FlightAvailabilities;

class Availability
{
    public ?FlightAvailabilities $flightAvailabilities;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->flightAvailabilities = new FlightAvailabilities($client);
    }
}
