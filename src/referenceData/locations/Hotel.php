<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelNameAutocomplete;
use Amadeus\Resources\Resource;

class Hotel
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
     * @return HotelNameAutocomplete[]
     * @throws ResponseException
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            '/v1/reference-data/locations/hotel',
            $params
        );

        return Resource::fromArray($response, HotelNameAutocomplete::class);
    }
}
