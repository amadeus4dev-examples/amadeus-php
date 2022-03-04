<?php declare(strict_types=1);

namespace Amadeus\Shopping\Availability;

use Amadeus\Amadeus;
use Amadeus\Resources\FlightAvailability;
use JsonMapper;
use JsonMapper_Exception;

class FlightAvailabilities
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
     * @return FlightAvailability[]
     * @throws JsonMapper_Exception
     */
    public function post(string $body): iterable
    {
        $headers = array(
            'Content-Type' => 'application/vnd.amadeus+json',
            'Accept'=> 'application/json, application/vnd.amadeus+json',
            'Authorization' => $this->client->getAuthorizedToken()->getHeader()
        );

        $response = $this->client->httpClient->post(
            '/v1/shopping/availability/flight-availabilities',[
            'headers' => $headers,
            'body' => $body,
        ]);

        $result = json_decode($response->getBody()->__toString());

        $data = $result->{'data'};

        $mapper = new JsonMapper();
        $mapper->bIgnoreVisibility = true;

        return $mapper->mapArray(
            $data, array(), FlightAvailability::class
        );
    }
}