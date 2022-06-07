<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Locations;

class ReferenceData
{
    /** @phpstan-ignore-next-line */
    private Amadeus $amadeus;

    public ?Locations $locations = null;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->locations = new Locations($amadeus);
    }
}
