<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Airport\DirectDestinations;

class Airport
{
    private ?DirectDestinations $directDestinations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->directDestinations = new DirectDestinations($amadeus);
    }

    /**
     * @return DirectDestinations|null
     */
    public function getDirectDestinations(): ?DirectDestinations
    {
        return $this->directDestinations;
    }
}
