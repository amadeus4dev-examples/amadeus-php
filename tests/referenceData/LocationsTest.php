<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations;
use Amadeus\Resources\Address;
use Amadeus\Resources\Analytics;
use Amadeus\Resources\GeoCode;
use Amadeus\Resources\Links;
use Amadeus\Resources\Location;
use Amadeus\Resources\Travelers;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * Endpoint
 * @covers \Amadeus\ReferenceData\Locations
 * @covers \Amadeus\ReferenceData\Locations\Hotels
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByCity
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByGeocode
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByHotels
 *
 * Resources
 * @covers \Amadeus\Resources\Address
 * @covers \Amadeus\Resources\Analytics
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\Links
 * @covers \Amadeus\Resources\Location
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Travelers
 */
final class LocationsTest extends TestCase
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
            PHPUnitUtil::RESOURCE_PATH_ROOT . "locations_get_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->params = array(
            "subType" => "CITY,AIRPORT",
            "keyword" => "MUC",
            "countryCode" => "DE"
        );
        $client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations", $this->params)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // When
        $locationsSearch = new Locations($this->amadeus);
        $locations = $locationsSearch->get($this->params);

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
        $this->assertTrue($address instanceof Address);
        $this->assertEquals("MUNICH", $address->getCityName());
        $this->assertEquals("MUC", $address->getCityCode());
        $this->assertEquals("GERMANY", $address->getCountryName());
        $this->assertEquals("DE", $address->getCountryCode());
        $this->assertEquals("EUROP", $address->getRegionCode());

        // Analytics
        $analytics = $locations[0]->getAnalytics();
        $this->assertTrue($analytics instanceof Analytics);

        // Travelers
        $travelers = $analytics->getTravelers();
        $this->assertTrue($travelers instanceof Travelers);
        $this->assertEquals(27, $travelers->getScore());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]),
            $locations[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'self'}),
            $self->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'geoCode'}),
            $geoCode->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'address'}),
            $address->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'analytics'}),
            $analytics->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'analytics'}->{'travelers'}),
            $travelers->__toString()
        );
    }
}
