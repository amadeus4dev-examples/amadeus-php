<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Shopping\Availability\FlightAvailabilities;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightAvailability
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
 */
final class FlightAvailabilitiesTest extends TestCase
{
    private Amadeus $amadeus;
    private string $body;
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

        $this->body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_availabilities_request_ok.json"
        );

        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_availabilities_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};

        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        $client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/shopping/availability/flight-availabilities", $this->body)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        $flightAvailabilitiesSearch = new FlightAvailabilities($this->amadeus);
        $flightAvailabilities = $flightAvailabilitiesSearch->post($this->body);
        $this->assertNotNull($flightAvailabilities);
        $this->assertEquals(43, sizeof($flightAvailabilities));
    }
}
