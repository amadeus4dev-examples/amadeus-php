<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/reference-data/recommended-locations" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getReferenceData()->getRecommendedLocations();
 *
 */
class RecommendedLocations
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
     * Travel Recommendations API:
     *
     * Returns a list of destination recommendations.
     *
     *      $amadeus->getReferenceData()->getRecommendedLocations()->get(["cityCodes"=>"PAR", "travelerCountryCode"=>"FR"]);
     *
     * @link https://developers.amadeus.com/self-service/category/trip/api-doc/travel-recommendations/api-reference
     *
     * @param array $params                 the parameters to send to the API
     * @return Location[]        an API resource
     * @throws ResponseException            when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/reference-data/recommended-locations",
            $params
        );

        return Resource::fromArray($response, Location::class);
    }
}
