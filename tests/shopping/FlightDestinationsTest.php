<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightDestination;
use Amadeus\Resources\FlightDestinationLinks;
use Amadeus\Resources\FlightPrice;
use Amadeus\Shopping\FlightDestinations;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\FlightDestinations
 *
 * @covers \Amadeus\Resources\FlightDestination
 * @covers \Amadeus\Resources\FlightPrice
 * @covers \Amadeus\Resources\FlightDestinationLinks
 * @covers \Amadeus\Resources\Resource
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-inspiration-search/api-reference
 */
final class FlightDestinationsTest extends TestCase
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
    public function test_given_client_when_call_flight_destinations_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_destinations_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["origin" => "MAD", "oneWay" => "false", "nonStop" => "false"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/shopping/flight-destinations", $params)
            ->willReturn($response);

        // When
        $flightDestinations = (new FlightDestinations($this->amadeus))->get($params);

        // Then
        $this->assertIsArray($flightDestinations);

        // Resources
        // FlightDestination
        $this->assertTrue($flightDestinations[0] instanceof FlightDestination);
        $this->assertEquals("flight-destination", $flightDestinations[0]->getType());
        $this->assertEquals("MAD", $flightDestinations[0]->getOrigin());
        $this->assertEquals("ALC", $flightDestinations[0]->getDestination());
        $this->assertEquals("2020-10-23", $flightDestinations[0]->getDepartureDate());
        $this->assertEquals("2020-10-26", $flightDestinations[0]->getReturnDate());

        // Price
        $price = $flightDestinations[0]->getPrice();
        $this->assertTrue($price instanceof FlightPrice);
        $this->assertEquals("52.52", $price->getTotal());

        // FlightDestinationLinks
        $links = $flightDestinations[0]->getLinks();
        $this->assertTrue($links instanceof FlightDestinationLinks);
        $this->assertNotNull($links->getFlightDates());
        $this->assertNotNull($links->getFlightOffers());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $flightDestinations[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'price'}),
            $price->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'links'}),
            $links->__toString()
        );
    }
}
