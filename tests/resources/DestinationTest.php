<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Resources\Destination;
use Amadeus\Resources\Resource;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Destination
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
 */
final class DestinationTest extends TestCase
{
    private iterable $destinations;

    /**
     * @Before
     */
    public function setUp(): void
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

        $arrayData = json_decode($body)->{'data'};
        $this->destinations = Resource::toResourceArray($arrayData, Destination::class);
    }

    public function testInitialize(): void
    {
        $this->assertTrue($this->destinations[0] instanceof Destination);
    }

    public function testGetValue(): void
    {
        $this->assertEquals("location", $this->destinations[0]->getType());
        $this->assertEquals("city", $this->destinations[0]->getSubtype());
        $this->assertEquals("Bangalore", $this->destinations[0]->getName());
        $this->assertEquals("BLR", $this->destinations[0]->getIataCode());
        $this->assertEquals(
            '{"type":"location","subtype":"city","name":"Bangalore","iataCode":"BLR"}',
            $this->destinations[0]->__toString()
        );
    }
}
