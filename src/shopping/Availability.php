<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Shopping\Availability\FlightAvailabilities;

class Availability
{
    private ?FlightAvailabilities $flightAvailabilities;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->flightAvailabilities = new FlightAvailabilities($amadeus);
    }

    /**
     * @return FlightAvailabilities|null
     */
    public function getFlightAvailabilities(): ?FlightAvailabilities
    {
        return $this->flightAvailabilities;
    }

}
