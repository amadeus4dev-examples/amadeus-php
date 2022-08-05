<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Hotel;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/locations/hotels/by-city" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getLocations()->getHotels()->getByCity();
 *
 */
class ByCity
{
    private Amadeus $amadeus;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Hotel List API:
     *
     * Returns a list of relevant hotels inside a city.
     *
     *      $amadeus->getReferenceData()->getLocations()->getHotels()->getByCity->get(
     *          ["cityCode" => "PAR"]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
     *
     * @param array $params         the parameters to send to the API
     * @return Hotel[]              an API resource
     * @throws ResponseException    when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/reference-data/locations/hotels/by-city",
            $params
        );

        return Resource::fromArray($response, Hotel::class);
    }
}
