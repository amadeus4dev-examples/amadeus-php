<?php declare(strict_types=1);

namespace Amadeus\Shopping\Availability;

use Amadeus\Amadeus;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\Resource;
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
        $response = $this->client->post(
            '/v1/shopping/availability/flight-availabilities',$body);

        return Resource::fromObject($response,FlightAvailability::class);
    }
}