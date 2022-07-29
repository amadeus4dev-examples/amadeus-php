<?php

declare(strict_types=1);

namespace Amadeus\Tests\Airport;

use Amadeus\Airport\Predictions\OnTime;
use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Request;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\OnTimePrediction;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Airport\Predictions\OnTime
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\OnTimePrediction
 *
 * @covers \Amadeus\Client\Response
 * @covers \Amadeus\Exceptions\ResponseException
 * @covers \Amadeus\Exceptions\ClientException
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airport-on-time-performance/api-reference
 */
final class OnTimeTest extends TestCase
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
    public function test_given_client_when_call_on_time_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "on_time_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["airportCode" => "NCE", "date" => "2022-11-01"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/airport/predictions/on-time", $params)
            ->willReturn($response);

        // When
        $onTime = new OnTime($this->amadeus);
        $predictions = $onTime->get($params);

        // Then
        $this->assertNotNull($predictions);

        // Resources
        // OnTimePrediction
        $this->assertTrue($predictions instanceof OnTimePrediction);
        $this->assertIsString($predictions->getType());
        $this->assertIsString($predictions->getSubtype());
        $this->assertIsString($predictions->getId());
        $this->assertIsString($predictions->getResult());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data),
            $predictions->__toString()
        );
    }
}
