<?php

declare(strict_types=1);

namespace Amadeus\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Location;
use Amadeus\Resources\Resource;
use Amadeus\Utils\PaginationAbstract;

class Locations extends PaginationAbstract
{
    protected Amadeus $client;
    protected string $className = Location::class;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $query
     * @return Location[]
     * @throws ResponseException
     */
    public function get(array $query): array
    {
        $response = $this->client->getWithArrayParams(
            '/v1/reference-data/locations',
            $query
        );

        return Resource::fromArray($response, Location::class);
    }

    /**
     * @param Location $resource
     * @return Location[]|null
     * @throws ResponseException
     */
    public function next($resource): ?array
    {
        $response = $this->client->getNextPage($resource->getResponse());
        return $this->pageResult($response);
    }

    /**
     * @param Location $resource
     * @return Location[]|null
     * @throws ResponseException
     */
    public function previous($resource): ?array
    {
        $response = $this->client->getPreviousPage($resource->getResponse());
        return $this->pageResult($response);
    }

    /**
     * @param Location $resource
     * @return Location[]|null
     * @throws ResponseException
     */
    public function first($resource): ?array
    {
        $response = $this->client->getFirstPage($resource->getResponse());
        return $this->pageResult($response);
    }

    /**
     * @param Location $resource
     * @return Location[]|null
     * @throws ResponseException
     */
    public function last($resource): ?array
    {
        $response = $this->client->getLastPage($resource->getResponse());
        return $this->pageResult($response);
    }
}
