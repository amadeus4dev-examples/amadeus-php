<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Resources\Destination;
use Amadeus\Resources\Resource;
use Amadeus\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Destination
 */
final class DestinationTest extends TestCase
{
    /**
     * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
     */
    public function test4ExampleValue(): void
    {
        $body =
            '{
              "data": [
                {
                  "type": "location",
                  "subtype": "city",
                  "name": "Bangalore",
                  "iataCode": "BLR"
                },
                {
                  "type": "location",
                  "subtype": "city",
                  "name": "Paris",
                  "iataCode": "PAR"
                }
              ],
              "meta": {
                "count": "2",
                "sort": "iataCode",
                "links": {
                  "self": "https://test.api.amadeus.com/v1/airport/direct-destination?departureAirportCode=NCE&max=2"
                }
              }
            }';

        $obj = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->getMock();

        $arrayData = json_decode($body)->{'data'};
        $destinations = array(new Destination());
        $destinations = Resource::toResourceArray($arrayData, Destination::class);

        $this->assertTrue($destinations[0] instanceof Destination);
        $this->assertEquals("location", $destinations[0]->getType());
        $this->assertEquals("city", $destinations[0]->getSubtype());
        $this->assertEquals("Bangalore", $destinations[0]->getName());
        $this->assertEquals("BLR", $destinations[0]->getIataCode());
    }
}
