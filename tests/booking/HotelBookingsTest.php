<?php

declare(strict_types=1);

namespace Amadeus\Tests\Booking;

use Amadeus\Amadeus;
use Amadeus\Booking\HotelBookings;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelBookingAssociatedRecord;
use Amadeus\Resources\HotelBookingLight;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Booking\HotelBookings
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\HotelBookingLight
 * @covers \Amadeus\Resources\HotelBookingAssociatedRecord
 *
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference
 */
final class HotelBookingsTest extends TestCase
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

        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_bookings_post_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_bookings_post_request_ok.json"
        );
        $client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/booking/hotel-bookings", $this->body)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // When
        $hotelBookings = (new HotelBookings($this->amadeus))->post($this->body);

        // Then
        $this->assertNotNull($hotelBookings);
        $this->assertEquals(1, sizeof($hotelBookings));

        // Resources
        // HotelBookingLight
        $this->assertTrue($hotelBookings[0] instanceof HotelBookingLight);
        $this->assertEquals("hotel-booking", $hotelBookings[0]->getType());
        $this->assertEquals("XD_8138319951754", $hotelBookings[0]->getId());
        $this->assertEquals("8138319951754", $hotelBookings[0]->getProviderConfirmationId());

        // HotelBookingAssociatedRecord
        $associatedRecords = $hotelBookings[0]->getAssociatedRecords();
        $this->assertTrue($associatedRecords[0] instanceof HotelBookingAssociatedRecord);
        $this->assertEquals("QVH2BX", $associatedRecords[0]->getReference());
        $this->assertEquals("GDS", $associatedRecords[0]->getOriginSystemCode());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]),
            $hotelBookings[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'associatedRecords'}[0]),
            $associatedRecords[0]->__toString()
        );
    }
}
