<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightDate;
use Amadeus\Resources\FlightDateLinks;
use Amadeus\Resources\FlightPrice;
use Amadeus\Shopping\FlightDates;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\FlightDates
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightDate
 * @covers \Amadeus\Resources\FlightPrice
 * @covers \Amadeus\Resources\FlightDateLinks
 *
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-cheapest-date-search/api-reference
 */
final class FlightDatesTest extends TestCase
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
    public function test_given_client_when_call_flight_dates_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_dates_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["origin" => "MAD", "destination" => "MUC"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/shopping/flight-dates", $params)
            ->willReturn($response);

        // When
        $flightDates = (new FlightDates($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($flightDates);
        $this->assertEquals(2, sizeof($flightDates));

        // Resources
        // FlightDate
        $this->assertTrue($flightDates[0] instanceof FlightDate);
        $this->assertEquals("flight-date", $flightDates[0]->getType());
        $this->assertEquals("MAD", $flightDates[0]->getOrigin());
        $this->assertEquals("MUC", $flightDates[0]->getDestination());
        $this->assertEquals("2020-07-29", $flightDates[0]->getDepartureDate());
        $this->assertEquals("2020-07-30", $flightDates[0]->getReturnDate());

        // FlightPrice
        $price = $flightDates[0]->getPrice();
        $this->assertTrue($price instanceof FlightPrice);
        $this->assertEquals("98.53", $price->getTotal());

        // FlightDateLink
        $links = $flightDates[0]->getLinks();
        $this->assertTrue($links instanceof FlightDateLinks);
        $this->assertEquals(
            "https://test.api.amadeus.com/v1/shopping/flight-destinations?origin=MAD&departureDate=2020-07-24,2021-01-19&oneWay=false&duration=1,15&nonStop=false&viewBy=DURATION",
            $links->getFlightDestinations()
        );
        $this->assertEquals(
            "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=MAD&destinationLocationCode=MUC&departureDate=2020-07-29&returnDate=2020-07-30&adults=1&nonStop=false",
            $links->getFlightOffers()
        );

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $flightDates[0]->__toString()
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
