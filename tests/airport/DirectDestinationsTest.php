<?php

declare(strict_types=1);

namespace Amadeus\Tests\Airport;

use Amadeus\Airport\DirectDestinations;
use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Request;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ClientException;
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
    private HTTPClient $client;

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
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "direct_destinations_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given OK
        $params = array(
            "departureAirportCode" => "NCE",
            "max" => 2
        );
        /*@phpstan-ignore-next-line*/
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/airport/direct-destinations", $params)
            ->willReturn($response);

        // When
        $directDestinations = new DirectDestinations($this->amadeus);
        $destinations = $directDestinations->get($params);

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
            PHPUnitUtil::toString($data[0]),
            $destinations[0]->__toString()
        );
    }

    /**
     * @throws ResponseException
     */
    public function testBadRequestOnEndpoint(): void
    {
        // Prepare exception
        $result = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "direct_destinations_get_response_ko.txt"
        );
        $request = $this->createMock(Request::class);
        $info = ["http_code"=>400, "header_size"=>497];
        $response = new Response($request, $info, $result);
        $exception = new ClientException($response);

        // Given
        $params = array(
            "departureAirportCode" => "NC",
            "max" => 2
        );
        /*@phpstan-ignore-next-line*/
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/airport/direct-destinations", $params)
            ->willThrowException($exception);

        $directDestinations = new DirectDestinations($this->amadeus);

        $this->expectException(ClientException::class); // Then
        $destinations = $directDestinations->get($params); // When
    }
}
