<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Activity;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\Activities\BySquare;

/**
 *  A namespaced client for the
 *  "/v1/shopping/activities" endpoints.
 *
 *  Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getActivities();
 *
 */
class Activities
{
    private Amadeus $amadeus;

    /**
     *   A namespaced client for the
     *   "/v1/shopping/activities/by-square" endpoints.
     */
    private BySquare $bySquare;

    /**
     * Constructor.
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->amadeus = $amadeus;
        $this->bySquare = new BySquare($amadeus);
    }

    /**
     *  Get a namespaced client for the
     *  "/v1/shopping/activities/by-square" endpoints.
     *
     * @return BySquare
     */
    public function getBySquare(): BySquare
    {
        return $this->bySquare;
    }

    /**
     * Tours and Activities API:
     *
     * Find a list of activities around a given location.
     *
     *      $amadeus->getShopping()->getActivities()->get(
     *              ["longitude" => 2.160873, "latitude" => 41.397158]
     *      );
     *
     * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
     *
     * @param   array $params       the parameters to send to the API
     * @return  Activity[]          an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(array $params): array
    {
        $response = $this->amadeus->getClient()->getWithArrayParams(
            "/v1/shopping/activities",
            $params
        );

        return Resource::fromArray($response, Activity::class);
    }
}
