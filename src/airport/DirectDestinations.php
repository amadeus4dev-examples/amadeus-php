<?php declare(strict_types=1);

namespace Amadeus\Airport;

use Amadeus\Amadeus;
use Amadeus\Resources\Destination;
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
    public function get(array $query) : iterable
    {
        $headers = array(
            'Authorization' => $this->client->getAuthorizedToken()->getHeader()
        );

        $response = $this->client->httpClient->get(
          '/v1/airport/direct-destinations',[
              'headers' => $headers,
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