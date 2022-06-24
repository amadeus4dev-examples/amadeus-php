<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Hotels\ByGeocode;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByGeocode
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Hotel
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\HotelAddress
 * @covers \Amadeus\Resources\HotelDistance
 *
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
 */
final class ByGeocodeTest extends TestCase
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
    public function test_given_client_when_call_hotels_by_geocode_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotels_by_geocode_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = array(
            "latitude" => "41.397158",
            "longitude" => "2.160873"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/hotels/by-geocode", $params)
            ->willReturn($response);

        // When
        $hotels = (new ByGeocode($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($hotels);
        $this->assertEquals(5, sizeof($hotels));

        // Resources
        // This endpoint share the same resource model with ByCity
        // See ByCityTest.php
    }
}
