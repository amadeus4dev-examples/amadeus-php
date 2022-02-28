<?php declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Resource\Destination;
use JsonMapper;
use JsonMapper_Exception;

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
     * @return Destination[]
     * @throws JsonMapper_Exception
     */
    public function getDestinations(array $query) : iterable
    {
        $header = array('Authorization' => $this->client->getToken()->getHeader());

        $response = $this->client->httpClient->get(
          '/v1/airport/direct-destinations',[
              'headers' => $header,
              'query' => $query,
        ]);

        $result = json_decode($response->getBody()->__toString());

        $data = $result->{'data'};

        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->mapArray(
            $data, array(), Destination::class
        );
    }

}