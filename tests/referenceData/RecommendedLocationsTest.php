<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\RecommendedLocations;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\RecommendedLocations
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\Location
 *
 * @link https://developers.amadeus.com/self-service/category/trip/api-doc/travel-recommendations/api-reference
 */
final class RecommendedLocationsTest extends TestCase
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
    public function test_given_client_when_call_recommended_locations_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "recommended_locations_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["cityCodes" => "PAR"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/reference-data/recommended-locations", $params)
            ->willReturn($response);

        // When
        $recommendedlocs = (new RecommendedLocations($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($recommendedlocs);
        $this->assertEquals(5, sizeof($recommendedlocs));

        // Resources
        // Location
        // See LocationsTest.php
    }
}
