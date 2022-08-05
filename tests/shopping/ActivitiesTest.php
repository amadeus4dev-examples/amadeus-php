<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\Activity;
use Amadeus\Resources\ElementaryPrice;
use Amadeus\Resources\GeoCode;
use Amadeus\Resources\Link;
use Amadeus\Shopping\Activities;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\Activities
 * @covers \Amadeus\Shopping\Activities\BySquare
 *
 * @covers \Amadeus\Resources\Activity
 * @covers \Amadeus\Resources\ElementaryPrice
 * @covers \Amadeus\Resources\GeoCode
 * @covers \Amadeus\Resources\Link
 * @covers \Amadeus\Resources\Resource
 * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
 */
final class ActivitiesTest extends TestCase
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
    public function test_given_client_when_call_activities_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "activities_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["longitude" => 2.160873, "latitude" => 41.397158];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v1/shopping/activities", $params)
            ->willReturn($response);

        // When
        $activities = (new Activities($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($activities);
        $this->assertEquals(17, sizeof($activities));

        // Resources
        // Activities
        $this->assertTrue($activities[0] instanceof Activity);
        $this->assertEquals("activity", $activities[0]->getType());
        $this->assertEquals(3273097, $activities[0]->getId());
        $this->assertNotNull($activities[0]->getName());
        $this->assertNotNull($activities[0]->getShortDescription());
        $this->assertNotNull($activities[0]->getDescription());
        $this->assertEquals("4.5", $activities[0]->getRating());
        $this->assertEquals(5, sizeof($activities[0]->getPictures()));
        $this->assertNotNull($activities[0]->getBookingLink());
        $this->assertEquals("2 hours", $activities[0]->getMinimumDuration());

        // Link
        $self = $activities[0]->getSelf();
        $this->assertTrue($self instanceof Link);
        $this->assertNotNull($self);

        // GeoCode
        $geoCode = $activities[0]->getGeoCode();
        $this->assertTrue($geoCode instanceof GeoCode);
        $this->assertNotNull($geoCode);

        // ElementaryPrice
        $price = $activities[0]->getPrice();
        $this->assertTrue($price instanceof ElementaryPrice);
        $this->assertEquals("0.0", $price->getAmount());

        // __toString
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $activities[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'price'}),
            $price->__toString()
        );
    }
}
