<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData\Locations\Hotels;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Hotels\ByHotels;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByHotels
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Hotel
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\HotelAddress
 * @covers \Amadeus\Resources\HotelDistance
 *
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
 */
final class ByHotelsTest extends TestCase
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
    public function test_given_client_when_call_hotels_by_hotels_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotels_by_hotels_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = array(
            "hotelIds" => "ACPAR419"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/hotels/by-hotels", $params)
            ->willReturn($response);

        // When
        $hotels = (new ByHotels($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($hotels);
        $this->assertEquals(1, sizeof($hotels));

        // Resources
        // This endpoint share the same resource model with ByCity
        // See ByCityTest.php
    }
}
