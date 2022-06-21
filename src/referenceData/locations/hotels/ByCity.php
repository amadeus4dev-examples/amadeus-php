<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Hotel;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/locations/hotels/by-city</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getLocations()->getHotels()->getByCity();
 * </code>
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
     * ###Hotel List API
     * <p>
     *    Returns a list of relevant hotels inside a city.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getLocations()->getHotels()->getByCity->get(
     *      ["cityCode" => "PAR"]
     *  );
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
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
