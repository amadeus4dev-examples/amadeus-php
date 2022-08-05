<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData\Locations;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations\Hotel;
use Amadeus\Resources\GeoCode;
use Amadeus\Resources\HotelAddress;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations\Hotel
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\HotelNameAutocomplete
 * @covers \Amadeus\Resources\HotelAddress
 * @covers \Amadeus\Resources\GeoCode
 *
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-name-autocomplete/api-reference
 */
final class HotelTest extends TestCase
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
    public function test_given_client_when_call_hotel_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = array(
            "keyword" => "PARI",
            "subType" => "HOTEL_GDS",
            "countryCode" => "FR",
            "lang" => "EN",
            "max" => 5
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations/hotel", $params)
            ->willReturn($response);

        // When
        $hotels = (new Hotel($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($hotels);
        $this->assertEquals(5, sizeof($hotels));

        // Resources
        // HotelNameAutoComplete
        $this->assertEquals("3422865", $hotels[0]->getId());
        $this->assertEquals("CITADINES BASTILLE MARAIS PARI", $hotels[0]->getName());
        $this->assertEquals("PAR", $hotels[0]->getIataCode());
        $this->assertEquals("HOTEL_GDS", $hotels[0]->getSubType());
        $this->assertEquals(70, $hotels[0]->getRelevance());
        $this->assertEquals("location", $hotels[0]->getType());
        $this->assertEquals(["AZPAROBA"], $hotels[0]->getHotelIds());

        // HotelAddress
        $address = $hotels[0]->getAddress();
        $this->assertTrue($address instanceof HotelAddress);
        $this->assertEquals("PARIS", $address->getCityName());
        $this->assertEquals("FR", $address->getCountryCode());

        // GeoCode
        $geoCode = $hotels[0]->getGeoCode();
        $this->assertTrue($geoCode instanceof GeoCode);
        $this->assertEquals(48.8581, $geoCode->getLatitude());
        $this->assertEquals(2.37113, $geoCode->getLongitude());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $hotels[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'address'}),
            $address->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'geoCode'}),
            $geoCode->__toString()
        );
    }
}
