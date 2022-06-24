<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Hotels\ByCity;
use Amadeus\Resources\LocationAddress;
use Amadeus\Resources\GeoCode;
use Amadeus\Resources\Hotel;
use Amadeus\Resources\HotelAddress;
use Amadeus\Resources\HotelDistance;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByCity
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Hotel
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\HotelAddress
 * @covers \Amadeus\Resources\HotelDistance
 *
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
 */
final class ByCityTest extends TestCase
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
    public function test_given_client_when_call_hotels_by_city_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotels_by_city_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = array(
            "cityCode" => "PAR"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/hotels/by-city", $params)
            ->willReturn($response);

        // When
        $hotels = (new ByCity($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($hotels);
        $this->assertEquals(2, sizeof($hotels));

        // Resources
        // Hotel
        $this->assertTrue($hotels[0] instanceof Hotel);
        $this->assertEquals("ZZ", $hotels[0]->getChainCode());
        $this->assertEquals("NCE", $hotels[0]->getIataCode());
        $this->assertEquals(504813011, $hotels[0]->getDupeId());
        $this->assertEquals("HOTEL 3", $hotels[0]->getName());
        $this->assertEquals("ZZNCENVX", $hotels[0]->getHotelId());

        // GeoCode
        $geoCode = $hotels[0]->getGeoCode();
        $this->assertTrue($geoCode instanceof GeoCode);
        $this->assertNotNull($geoCode);

        // HotelAddress
        $address = $hotels[0]->getAddress();
        $this->assertTrue($address instanceof HotelAddress);
        $this->assertNotNull($address);

        // HotelDistance
        $distance = $hotels[0]->getDistance();
        $this->assertTrue($distance instanceof HotelDistance);
        $this->assertEquals(0.92, $distance->getValue());
        $this->assertEquals("KM", $distance->getUnit());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $hotels[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'geoCode'}),
            $geoCode->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'address'}),
            $address->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'distance'}),
            $distance->__toString()
        );
    }
}
