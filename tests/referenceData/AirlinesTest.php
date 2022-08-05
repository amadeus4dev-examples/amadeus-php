<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Airlines;
use Amadeus\Resources\Airline;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Airlines
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Airline
 *
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/airline-code-lookup/api-reference
 */
final class AirlinesTest extends TestCase
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
    public function test_given_client_when_call_airlines_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "airlines_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["iataCodes" => "BA"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/airlines", $params)
            ->willReturn($response);

        // When
        $airlines = (new Airlines($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($airlines);
        $this->assertEquals(1, sizeof($airlines));

        // Resources
        // Airline
        $this->assertTrue($airlines[0] instanceof Airline);
        $this->assertEquals("airline", $airlines[0]->getType());
        $this->assertEquals("BA", $airlines[0]->getIataCode());
        $this->assertEquals("BAW", $airlines[0]->getIcaoCode());
        $this->assertEquals("BRITISH AIRWAYS", $airlines[0]->getBusinessName());
        $this->assertEquals("BRITISH A/W", $airlines[0]->getCommonName());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $airlines[0]->__toString()
        );
    }
}
