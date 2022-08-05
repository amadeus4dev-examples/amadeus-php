<?php

declare(strict_types=1);

namespace Amadeus\Tests\Travel\Predictions;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\DelayPrediction;
use Amadeus\Tests\PHPUnitUtil;
use Amadeus\Travel\Predictions\FlightDelay;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Travel\Predictions\FlightDelay
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\DelayPrediction
 *
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-delay-prediction/api-reference
 */
final class FlightDelayTest extends TestCase
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
    public function test_given_client_when_call_flight_delay_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_delay_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["originLocationCode"=>"NCE", "destinationLocationCode"=>"IST",
            "departureDate"=>"2020-08-01", "departureTime"=>"18:20:00",
            "arrivalDate"=>"2020-08-01", "arrivalTime"=>"22:15:00",
            "aircraftCode"=>"321", "carrierCode"=>"TK",
            "flightNumber"=>"1816", "duration"=>"PT31H10M"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/travel/predictions/flight-delay", $params)
            ->willReturn($response);

        // When
        $flightDelay = (new FlightDelay($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($flightDelay);
        $this->assertEquals(4, sizeof($flightDelay));

        // Resources
        // DelayPrediction
        $this->assertTrue($flightDelay[0] instanceof DelayPrediction);
        $this->assertEquals("TK1816NCEIST20200801", $flightDelay[0]->getId());
        $this->assertEquals("0.26012117", $flightDelay[0]->getProbability());
        $this->assertEquals("LESS_THAN_30_MINUTES", $flightDelay[0]->getResult());
        $this->assertEquals("flight-delay", $flightDelay[0]->getSubType());
        $this->assertEquals("prediction", $flightDelay[0]->getType());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $flightDelay[0]->__toString()
        );
    }
}
