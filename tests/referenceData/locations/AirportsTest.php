<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Airports;
use Amadeus\Resources\LocationDistance;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations\Airports
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Location
 * @covers \Amadeus\Resources\LocationDistance
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-nearest-relevant/api-reference
 */
final class AirportsTest extends TestCase
{
    private Amadeus $amadeus;
    private HTTPClient $client;

    /**
     * @Before
     */
    public function setUp(): void
    {
        // Mock an Amadeus with HTTPClient
        $this->amadeus = $this->createMock(Amadeus::class);
        $this->client = $this->createMock(HTTPClient::class);
        $this->amadeus->expects($this->any())
            ->method("getClient")
            ->willReturn($this->client);
    }

    /**
     * @throws ResponseException
     */
    public function test_given_client_when_call_airports_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "airports_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["latitude"=>51.57285, "longitude"=>-0.44161, "radius"=>500];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/airports", $params)
            ->willReturn($response);

        // When
        $airports = (new Airports($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($airports);
        $this->assertEquals(10, sizeof($airports));

        // Resources
        // Location
        // Most of the properties in Location Resource Model have been tested in LocationsTest.php
        // In this test, only test the missing part
        $this->assertEquals(350.54587, $airports[0]->getRelevance());

        // LocationDistance
        $distance = $airports[0]->getDistance();
        $this->assertTrue($distance instanceof LocationDistance);
        $this->assertEquals("11", $distance->getValue());
        $this->assertEquals("KM", $distance->getUnit());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $airports[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'distance'}),
            $distance->__toString()
        );
    }
}
