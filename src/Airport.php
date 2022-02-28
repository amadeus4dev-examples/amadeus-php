<?php

namespace Amadeus;

use Amadeus\Airport\DirectDestinations;

class Airport
{
    public ?DirectDestinations $directDestination;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->directDestination = new DirectDestinations($client);
    }

}