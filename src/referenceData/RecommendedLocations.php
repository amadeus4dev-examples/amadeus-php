<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/v1/reference-data/recommended-locations</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getReferenceData()->getRecommendedLocations();
 * </code>
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
     * ###Travel Recommendations API
     * <p>
     *    Returns a list of destination recommendations.
     * </p>
     *
     * <code>
     *  $amadeus->getReferenceData()->getRecommendedLocations()->get(["cityCodes"=>"PAR", "travelerCountryCode"=>"FR"]);
     * </code>
     *
     * @see https://developers.amadeus.com/self-service/category/trip/api-doc/travel-recommendations/api-reference
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
