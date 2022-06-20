<?php

declare(strict_types=1);

namespace Amadeus\Tests\Airport;

use Amadeus\Airport\DirectDestinations;
use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Destination;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Airport\DirectDestinations
 *
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

        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "direct_destinations_get_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->params = array(
            "departureAirportCode" => "NCE",
            "max" => 2
        );
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
        // When
        $directDestinations = new DirectDestinations($this->amadeus);
        $destinations = $directDestinations->get($this->params);

        // Then
        $this->assertNotNull($destinations);
        $this->assertEquals(2, sizeof($destinations));

        // Resources
        // Destination
        $this->assertTrue($destinations[0] instanceof Destination);
        $this->assertEquals("location", $destinations[0]->getType());
        $this->assertEquals("city", $destinations[0]->getSubtype());
        $this->assertEquals("Bangalore", $destinations[0]->getName());
        $this->assertEquals("BLR", $destinations[0]->getIataCode());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]),
            $destinations[0]->__toString()
        );
    }
}
