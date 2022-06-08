<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Airport\DirectDestinations;
use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Locations;
use Amadeus\Shopping\Availability\FlightAvailabilities;
use Amadeus\Shopping\FlightOffers;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\BasicHTTPClient
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Airport
 * @covers \Amadeus\Airport\DirectDestinations
 * @covers \Amadeus\Shopping
 * @covers \Amadeus\Shopping\Availability
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 * @covers \Amadeus\Shopping\FlightOffers
 * @covers \Amadeus\ReferenceData
 * @covers \Amadeus\ReferenceData\Locations
 */
final class NamespaceTest extends TestCase
{
    public function testAllNamespacesExist(): void
    {
        $amadeus = Amadeus::builder("id", "secret")->build();

        // Airport
        $this->assertNotNull($amadeus->getAirport());
        $this->assertNotNull($amadeus->getAirport()->getDirectDestinations());

        // Shopping
        $this->assertNotNull($amadeus->getShopping());
        $this->assertNotNull($amadeus->getShopping()->getAvailability());
        $this->assertNotNull($amadeus->getShopping()->getAvailability()->getFlightAvailabilities());
        $this->assertNotNull($amadeus->getShopping()->getFlightOffers());

        // ReferenceData
        $this->assertNotNull($amadeus->getReferenceData());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations());
    }

    private Amadeus $amadeus;
    private HTTPClient $client;
    private array $params;
    private string $body;
    private Response $multiResponse;
    private Response $singleResponse;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $this->amadeus = $this->createMock(Amadeus::class);
        $this->client = $this->createMock(HTTPClient::class);

        $this->amadeus->expects($this->any())
            ->method("getClient")
            ->willReturn($this->client);

        $this->params = array("airline"=>"1X");
        $this->body = "{ \"data\": [{}]}";

        // Prepare a plural response
        $jsonArray = array();
        $jsonArray[] = (object)[];
        $jsonArray[] = (object)[];
        $this->multiResponse = $this->createMock(Response::class);
        $this->multiResponse->expects($this->any())
            ->method("getData")
            ->willReturn($jsonArray);

        // Prepare a single response
        $jsonObject = (object)[];
        $jsonObject->foo = "bar";
        $this->singleResponse = $this->createMock(Response::class);
        $this->singleResponse->expects($this->any())
            ->method("getData")
            ->willReturn($jsonObject);
    }

    // ------ GET ------
    /**
     * @throws ResponseException
     */
    public function testAirportRoutesGetMethod(): void
    {
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/airport/direct-destinations", $this->params)
            ->willReturn($this->multiResponse);
        $directDestinations = new DirectDestinations($this->amadeus);
        $this->assertNotNull($directDestinations->get($this->params));
        $this->assertEquals(2, sizeof($directDestinations->get($this->params)));
    }

    /**
     * @throws ResponseException
     */
    public function testFlightOffersSearchGetMethod(): void
    {
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v2/shopping/flight-offers", $this->params)
            ->willReturn($this->multiResponse);
        $flightOffers = new FlightOffers($this->amadeus);
        $this->assertNotNull($flightOffers->get($this->params));
        $this->assertEquals(2, sizeof($flightOffers->get($this->params)));
    }

    /**
     * @throws ResponseException
     */
    public function testCityAndAirportSearchGetMethod(): void
    {
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/locations", $this->params)
            ->willReturn($this->multiResponse);
        $locations = new Locations($this->amadeus);
        $this->assertNotNull($locations->get($this->params));
        $this->assertEquals(2, sizeof($locations->get($this->params)));
    }

    // ------ POST ------
    /**
     * @throws ResponseException
     */
    public function testFlightAvailabilitiesPostMethod(): void
    {
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/shopping/availability/flight-availabilities", $this->body)
            ->willReturn($this->multiResponse);
        $flightAvailabilities = new FlightAvailabilities($this->amadeus);
        $this->assertNotNull($flightAvailabilities->post($this->body));
        $this->assertEquals(2, sizeof($flightAvailabilities->post($this->body)));
    }

    /**
     * @throws ResponseException
     */
    public function testFlightOffersSearchPostMethod(): void
    {
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v2/shopping/flight-offers", $this->body)
            ->willReturn($this->multiResponse);
        $flightOffers = new FlightOffers($this->amadeus);
        $this->assertNotNull($flightOffers->post($this->body));
        $this->assertEquals(2, sizeof($flightOffers->post($this->body)));
    }
}
