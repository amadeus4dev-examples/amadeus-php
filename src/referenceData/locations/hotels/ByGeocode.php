<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Hotel;
use Amadeus\Resources\Resource;

class ByGeocode
{
    private Amadeus $amadeus;

    /**
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * @param array $params
     * @return Hotel[]
     * @throws ResponseException
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/reference-data/locations/hotels/by-geocode",
            $params
        );

        return Resource::fromArray($response, Hotel::class);
    }
}
