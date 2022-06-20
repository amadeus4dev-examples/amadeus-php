<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelNameAutocomplete;
use Amadeus\Resources\Resource;

/**
 * Hotel Name Autocomplete API
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-name-autocomplete/api-reference
 */
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
