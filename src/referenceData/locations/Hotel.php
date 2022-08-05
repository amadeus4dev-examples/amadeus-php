<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelNameAutocomplete;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations/hotel" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocations()->getHotel();
 *
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
     * Hotel Name Autocomplete API
     *
     *      $amadeus->getReferenceData()->getLocations()->getHotel()->get(
     *          ["keyword"=>"PARI", "subType"=>"HOTEL_GDS"]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-name-autocomplete/api-reference
     *
     * @param array $params                 the parameters to send to the API
     * @return HotelNameAutocomplete[]      an API resource
     * @throws ResponseException            when an exception occurs
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
