<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations;
use Amadeus\Resources\LocationAddress;
use Amadeus\Resources\LocationAnalytics;
use Amadeus\Resources\GeoCode;
use Amadeus\Resources\Links;
use Amadeus\Resources\Location;
use Amadeus\Resources\LocationAnalyticsTravelers;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Locations
 * @covers \Amadeus\ReferenceData\Locations\Hotel
 * @covers \Amadeus\ReferenceData\Locations\Hotels
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByCity
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByGeocode
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByHotels
 * @covers \Amadeus\ReferenceData\Locations\Airports
 *
 * @covers \Amadeus\Resources\LocationAddress
 * @covers \Amadeus\Resources\LocationAnalytics
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\Links
 * @covers \Amadeus\Resources\Location
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\LocationAnalyticsTravelers
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference
 */
final class LocationsTest extends TestCase
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
    public function test_given_client_when_call_locations_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "locations_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = array(
            "subType" => "CITY,AIRPORT",
            "keyword" => "MUC",
            "countryCode" => "DE"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations", $params)
            ->willReturn($response);

        // When
        $locationsSearch = new Locations($this->amadeus);
        $locations = $locationsSearch->get($params);

        // Then
        $this->assertNotNull($locations);
        $this->assertEquals(2, sizeof($locations));

        // Resources
        // Location
        $this->assertTrue($locations[0] instanceof Location);
        $this->assertEquals("CMUC", $locations[0]->getId());
        $this->assertEquals("location", $locations[0]->getType());
        $this->assertEquals("CITY", $locations[0]->getSubType());
        $this->assertEquals("MUNICH INTERNATIONAL", $locations[0]->getName());
        $this->assertEquals("MUNICH/DE:MUNICH INTERNATIONAL", $locations[0]->getDetailedName());
        $this->assertEquals("+02:00", $locations[0]->getTimeZoneOffset());
        $this->assertEquals("MUC", $locations[0]->getIataCode());

        // Links
        $self = $locations[0]->getSelf();
        $this->assertTrue($self instanceof Links);
        $this->assertEquals(
            "https://test.api.amadeus.com/v1/reference-data/locations/CMUC",
            $self->getHref()
        );
        $this->assertEquals(array("GET"), $self->getMethods());

        // GeoCode
        $geoCode = $locations[0]->getGeoCode();
        $this->assertTrue($geoCode instanceof GeoCode);
        $this->assertEquals(48.35378, $geoCode->getLatitude());
        $this->assertEquals(11.78609, $geoCode->getLongitude());

        // Address
        $address = $locations[0]->getAddress();
        $this->assertTrue($address instanceof LocationAddress);
        $this->assertEquals("MUNICH", $address->getCityName());
        $this->assertEquals("MUC", $address->getCityCode());
        $this->assertEquals("GERMANY", $address->getCountryName());
        $this->assertEquals("DE", $address->getCountryCode());
        $this->assertEquals("EUROP", $address->getRegionCode());

        // Analytics
        $analytics = $locations[0]->getAnalytics();
        $this->assertTrue($analytics instanceof LocationAnalytics);

        // Travelers
        $travelers = $analytics->getTravelers();
        $this->assertTrue($travelers instanceof LocationAnalyticsTravelers);
        $this->assertEquals(27, $travelers->getScore());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $locations[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'self'}),
            $self->__toString()
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
            PHPUnitUtil::toString($data[0]->{'analytics'}),
            $analytics->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'analytics'}->{'travelers'}),
            $travelers->__toString()
        );
    }
}
