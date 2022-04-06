<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Shopping\Availability;

class Shopping
{
    public ?Availability $availability;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->availability = new Availability($client);
    }
}
