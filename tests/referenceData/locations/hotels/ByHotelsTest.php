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
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
 */
final class ByHotelsTest extends TestCase
{
    private Amadeus $amadeus;
    private array $params;
    private array $data;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $this->amadeus = $this->createMock(Amadeus::class);
        $client = $this->createMock(HTTPClient::class);
        $this->amadeus->expects($this->any())
            ->method("getClient")
            ->willReturn($client);

        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotels_by_hotels_get_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->params = array(
            "hotelIds" => "ACPAR419"
        );
        $client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/hotels/by-hotels", $this->params)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // When
        $hotels = (new ByHotels($this->amadeus))->get($this->params);

        // Then
        $this->assertNotNull($hotels);
        $this->assertEquals(1, sizeof($hotels));

        // Resources
        // This endpoint share the same resource model with ByCity
        // See ByCityTest.php
    }
}
