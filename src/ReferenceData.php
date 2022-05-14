<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\ReferenceData\Locations;

class ReferenceData
{
    /** @phpstan-ignore-next-line */
    private Amadeus $client;

    public ?Locations $locations = null;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->client = $client;
        $this->locations = new Locations($client);
    }
}
