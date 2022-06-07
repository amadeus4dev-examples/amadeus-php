<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Airport\DirectDestinations;

class Airport
{
    /** @phpstan-ignore-next-line */
    private Amadeus $amadeus;

    public ?DirectDestinations $directDestinations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->directDestinations = new DirectDestinations($amadeus);
    }
}
