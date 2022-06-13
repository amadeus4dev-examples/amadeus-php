<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Airport\DirectDestinations;
use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Destination
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
 */
final class DirectDestinationsTest extends TestCase
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

        $this->params = array(
            "departureAirportCode" => "MAD",
            "max" => 2
        );

        $fileContent = PHPUnitUtil::readFile(".././resources/__files/direct_destinations_response_ok.json");
        $this->data = json_decode($fileContent)->{'data'};

        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        $client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/airport/direct-destinations", $this->params)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        $directDestinations = new DirectDestinations($this->amadeus);
        $destinations = $directDestinations->get($this->params);
        $this->assertNotNull($destinations);
        $this->assertEquals(2, sizeof($destinations));

        $this->assertEquals("location", $destinations[0]->getType());
        $this->assertEquals("city", $destinations[0]->getSubtype());
        $this->assertEquals("ALBACETE", $destinations[0]->getName());
        $this->assertEquals("ABC", $destinations[0]->getIataCode());
        $this->assertEquals(
            json_encode($this->data[0], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
            $destinations[0]->__toString()
        );
    }

}
