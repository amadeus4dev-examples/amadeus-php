<?php declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Airport\DirectDestinations;
use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Response;
use Amadeus\Shopping\Availability\FlightAvailabilities;
use PHPUnit\Framework\TestCase;

final class NamespaceTest extends TestCase
{
    public function testAllNamespacesExist()
    {
        $client = Amadeus::
            builder("id", "secret")
            ->build();

        // Airport
        $this->assertNotNull($client->airport);
        $this->assertNotNull($client->airport->directDestinations);

        // Shopping
        $this->assertNotNull($client->shopping);
        $this->assertNotNull($client->shopping->availability);
        $this->assertNotNull($client->shopping->availability->flightAvailabilities);
    }

    private Amadeus $client;
    private array $params;
    private string $body;
    private Response $multiResponse;
    private Response $singleResponse;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $this->client = $this->createMock(Amadeus::class);
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

    /**
     * @throws ResponseException
     */
    public function testGetMethods()
    {
        // Testing Airport Routes GET API
        $this->client->expects($this->any())
            ->method("get")
            ->with("/v1/airport/direct-destinations", $this->params)
            ->willReturn($this->multiResponse);
        $directDestinations = new DirectDestinations($this->client);
        $this->assertNotNull($directDestinations->get($this->params));
        $this->assertEquals(2, sizeof($directDestinations->get($this->params)));

    }

    /**
     * @throws ResponseException
     */
    public function testPostMethods()
    {
        // Testing Flight Availabilities POST API
        $this->client->expects($this->any())
            ->method("post")
            ->with("/v1/shopping/availability/flight-availabilities", $this->body)
            ->willReturn($this->multiResponse);
        $flightAvailabilities = new FlightAvailabilities($this->client);
        $this->assertNotNull($flightAvailabilities->post($this->body));
        $this->assertEquals(2, sizeof($flightAvailabilities->post($this->body)));

    }

}