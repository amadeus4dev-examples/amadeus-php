<?php

declare(strict_types=1);

namespace Amadeus\Shopping\Activities;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Activity;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/shopping/activities/by-square" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getActivities()->getBySquare();
 *
 */
class BySquare
{
    private Amadeus $amadeus;

    /**
     * Constructor.
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
    }

    /**
     * Tours and Activities API:
     *
     * Find a list of activities within a square defined by cardinal points.
     *
     *      $amadeus->getShopping()->getActivities()->getBySquare()->get(
     *          ["west" => 2.160873, "north" => 41.397158, "south" => 41.394582, "east" => 2.177181]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  Activity[]            an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/shopping/activities/by-square",
            $params
        );

        return Resource::fromArray($response, Activity::class);
    }
}
