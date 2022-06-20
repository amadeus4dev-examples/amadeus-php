<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelContent;
use Amadeus\Resources\HotelOffer;
use Amadeus\Shopping\HotelOffers;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\HotelOffers
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\HotelOffers
 * @covers \Amadeus\Resources\HotelContent
 * @covers \Amadeus\Resources\HotelOffer
 *
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
 */
final class HotelOffersTest extends TestCase
{
    private Amadeus $amadeus;
    private array $params;
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
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_offers_get_response_ok.json"
        );
        $this->data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($this->data);

        // Given
        $this->params = array(
            "hotelIds" => "MCLONGHM",
            "adults" => 1,
            "checkInDate" => "2021-11-20"
        );
        $client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v3/shopping/hotel-offers", $this->params)
            ->willReturn($response);
    }

    /**
     * @throws ResponseException
     */
    public function testEndpoint(): void
    {
        // When
        $hotelOffers = (new HotelOffers($this->amadeus))->get($this->params);

        // Then
        $this->assertNotNull($hotelOffers);
        $this->assertEquals(1, sizeof($hotelOffers));

        // Resources
        // HotelOffers
        $this->assertTrue($hotelOffers[0] instanceof \Amadeus\Resources\HotelOffers);
        $this->assertEquals("hotel-offers", $hotelOffers[0]->getType());
        $this->assertEquals(true, $hotelOffers[0]->getAvailable());
        $this->assertEquals(
            "https://test.api.amadeus.com/v3/shopping/hotel-offers".
            "?hotelIds=HLLON101&adults=1&checkInDate=2021-11-20&paymentPolicy=NONE&roomQuantity=1",
            $hotelOffers[0]->getSelf()
        );

        // HotelContent
        $hotel = $hotelOffers[0]->getHotel();
        $this->assertTrue($hotel instanceof HotelContent);
        $this->assertEquals("hotel", $hotel->getType());
        $this->assertEquals("HLLON101", $hotel->getHotelId());
        $this->assertEquals("HL", $hotel->getChainCode());
        $this->assertEquals("700027723", $hotel->getDupeId());
        $this->assertEquals("THE TRAFALGAR", $hotel->getName());
        $this->assertEquals("LON", $hotel->getCityCode());
        $this->assertEquals(51.50729, $hotel->getLatitude());
        $this->assertEquals(-0.12889, $hotel->getLongitude());

        // HotelOffer
        // See HotelOfferTest.php
        $offers = $hotelOffers[0]->getOffers();
        $this->assertNotNull($offers);
        $this->assertTrue($offers[0] instanceof HotelOffer);

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]),
            $hotelOffers[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'hotel'}),
            $hotel->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($this->data[0]->{'offers'}[0]),
            $offers[0]->__toString()
        );
    }
}
