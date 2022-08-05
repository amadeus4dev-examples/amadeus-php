<?php

declare(strict_types=1);

namespace Amadeus\Shopping;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Resource;

/**
 * A namespaced client for the
 * "/v1/shopping/activities/:activity_id" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getShopping()->getActivity();
 *
 */
class Activity
{
    private Amadeus $amadeus;
    private string $activityId;

    /**
     * Constructor.
     * @param Amadeus $amadeus
     * @param string $activityId
     */
    public function __construct(Amadeus $amadeus, string $activityId)
    {
        $this->amadeus = $amadeus;
        $this->activityId = $activityId;
    }

    /**
     * Tours and Activities API:
     *
     * Find a single activity from a given id.
     *
     *      $amadeus->getShopping()->getActivity("4615")->get();
     *
     * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
     *
     * @return  \Amadeus\Resources\Activity          an API resource
     * @throws  ResponseException   when an exception occurs
     */
    public function get(): object
    {
        $response = $this->amadeus->getClient()->getWithOnlyPath(
            "/v1/shopping/activities"."/".$this->activityId
        );

        return Resource::fromObject($response, \Amadeus\Resources\Activity::class);
    }
}
