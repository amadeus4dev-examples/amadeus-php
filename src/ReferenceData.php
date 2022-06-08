<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Locations;

class ReferenceData
{
    private ?Locations $locations;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->locations = new Locations($amadeus);
    }

    /**
     * @return Locations|null
     */
    public function getLocations(): ?Locations
    {
        return $this->locations;
    }
}
