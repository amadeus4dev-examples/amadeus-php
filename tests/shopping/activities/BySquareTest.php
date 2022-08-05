<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping\Activities;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Shopping\Activities\BySquare;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\Activities\BySquare
 *
 * @covers \Amadeus\Resources\Activity
 * @covers \Amadeus\Resources\Resource
 * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
 */
final class BySquareTest extends TestCase
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
    public function test_given_client_when_call_activities_by_square_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "activities_by_square_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["west" => 2.160873, "north" => 41.397158, "south" => 41.394582, "east" => 2.177181];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/shopping/activities/by-square", $params)
            ->willReturn($response);

        // When
        $activities = (new BySquare($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($activities);
        $this->assertEquals(57, sizeof($activities));

        // Resource
        // Activity
        // See ActivitiesTest.php
    }
}
