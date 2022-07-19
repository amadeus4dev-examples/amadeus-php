<?php

declare(strict_types=1);

namespace Amadeus\Tests\ReferenceData;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\ReferenceData\Location;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\ReferenceData\Location
 *
 * @covers \Amadeus\Resources\Location
 * @covers \Amadeus\Resources\Resource
 */
final class LocationTest extends TestCase
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
    public function test_given_client_when_call_location_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "location_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $locationId = "CMUC";
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithOnlyPath")
            ->with("/v1/reference-data/locations"."/". $locationId)
            ->willReturn($response);

        // When
        $location = (new Location($this->amadeus, $locationId))->get();

        // Then
        $this->assertNotNull($location);

        // Resource
        // Location
        // See LocationsTest.php
        $this->assertTrue($location instanceof \Amadeus\Resources\Location);
    }
}
