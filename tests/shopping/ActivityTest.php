<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Shopping\Activity;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\Activity
 *
 * @covers \Amadeus\Resources\Activity
 * @covers \Amadeus\Resources\Resource
 * @see https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
 */
final class ActivityTest extends TestCase
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
    public function test_given_client_when_call_activity_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "activity_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $activityId = "3044851";
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithOnlyPath")
            ->with("/v1/shopping/activities"."/".$activityId)
            ->willReturn($response);

        // When
        $activity = (new Activity($this->amadeus, $activityId))->get();

        // Then
        $this->assertNotNull($activity);

        // Resource
        // Activity
        // See ActivitiesTest.php
    }
}
