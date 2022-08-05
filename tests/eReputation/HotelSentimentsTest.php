<?php

declare(strict_types=1);

namespace Amadeus\Tests\EReputation;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\EReputation\HotelSentiments;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelSentiment;
use Amadeus\Resources\HotelSentimentDetails;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\EReputation\HotelSentiments
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\HotelSentiment
 * @covers \Amadeus\Resources\HotelSentimentDetails
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-ratings/api-reference
 */
final class HotelSentimentsTest extends TestCase
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
    public function test_given_client_when_call_hotel_sentiments_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_sentiments_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["hotelIds" => "TELONMFS"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v2/e-reputation/hotel-sentiments", $params)
            ->willReturn($response);

        // When
        $hotelSentiments = (new HotelSentiments($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($hotelSentiments);
        $this->assertEquals(1, sizeof($hotelSentiments));

        // Resources
        // HotelSentiment
        $this->assertTrue($hotelSentiments[0] instanceof HotelSentiment);
        $this->assertEquals("TELONMFS", $hotelSentiments[0]->getHotelId());
        $this->assertEquals(81, $hotelSentiments[0]->getOverallRating());
        $this->assertEquals(2667, $hotelSentiments[0]->getNumberOfReviews());
        $this->assertEquals(2666, $hotelSentiments[0]->getNumberOfRatings());
        $this->assertEquals("hotelSentiment", $hotelSentiments[0]->getType());

        // HotelSentimentDetails
        $sentiments = $hotelSentiments[0]->getSentiments();
        $this->assertTrue($sentiments instanceof HotelSentimentDetails);
        $this->assertEquals(89, $sentiments->getStaff());
        $this->assertEquals(89, $sentiments->getLocation());
        $this->assertEquals(80, $sentiments->getService());
        $this->assertEquals(87, $sentiments->getRoomComforts());
        $this->assertEquals(72, $sentiments->getInternet());
        $this->assertEquals(78, $sentiments->getSleepQuality());
        $this->assertEquals(75, $sentiments->getValueForMoney());
        $this->assertEquals(75, $sentiments->getFacilities());
        $this->assertEquals(81, $sentiments->getCatering());
        $this->assertEquals(81, $sentiments->getPointsOfInterest());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $hotelSentiments[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'sentiments'}),
            $sentiments->__toString()
        );
    }
}
