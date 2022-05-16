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
    private array $data;
    private Destination $destination;

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

        $this->data = json_decode($body)->{'data'};
        $this->destination = Resource::toResourceArray($this->data, Destination::class)[0];
    }

    public function testGetValue(): void
    {
        $this->assertEquals("location", $this->destination->getType());
        $this->assertEquals("city", $this->destination->getSubtype());
        $this->assertEquals("Bangalore", $this->destination->getName());
        $this->assertEquals("BLR", $this->destination->getIataCode());
        $this->assertEquals(
            json_encode($this->data[0], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
            $this->destination->__toString()
        );
    }
}
