<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Locations;

class ReferenceData
{
    /** @phpstan-ignore-next-line */
    private Amadeus $amadeus;

    private ?Locations $locations = null;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
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
