<?php declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Resources\Destination;
use Amadeus\Resources\Resource;
use Exception;

class DirectDestinations
{
    private Amadeus $client;

    /**
     * @param Amadeus $client
     */
    public function __construct(Amadeus $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $query
     * @return iterable
     * @throws Exception
     */
    public function get(array $query) : iterable
    {
        $response = $this->client->get(
            '/v1/airport/direct-destinations',$query);

        return Resource::fromArray($response,Destination::class);
    }

}