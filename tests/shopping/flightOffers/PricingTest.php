<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping\FlightOffers;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\FlightOfferPricingOutput;
use Amadeus\Resources\Resource;
use Amadeus\Shopping\FlightOffers\Pricing;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\FlightOffers\Pricing
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightOfferPricingOutput
 * @covers \Amadeus\Resources\FlightOffer
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference
 */
final class PricingTest extends TestCase
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
    public function testGivenClientWhenCallPricingThenOk(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_offers_price_post_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_offers_price_post_request_ok.json"
        );
        $flightOffers1 = Resource::toResourceArray(
            json_decode($body)->{'data'}->{'flightOffers'},
            FlightOffer::class
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/shopping/flight-offers/pricing", $body)
            ->willReturn($response);

        // When
        $pricing = new Pricing($this->amadeus);
        $pricingOutput = $pricing->post($body);
        $pricingOutput2 = $pricing->postWithFlightOffers($flightOffers1);

        // Then
        $this->assertNotNull($pricingOutput);
        $this->assertNotNull($pricingOutput2);

        // Resource
        // FlightOffersPricingOutput
        $this->assertTrue($pricingOutput instanceof FlightOfferPricingOutput);
        $this->assertEquals("flight-offers-pricing", $pricingOutput->getType());

        // FlightOffer
        // See FlightOffersTest.php
        $flightOffers = $pricingOutput->getFlightOffers();
        $this->assertNotNull($flightOffers);
        $this->assertTrue($flightOffers[0] instanceof FlightOffer);

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data),
            $pricingOutput->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'flightOffers'}[0]),
            $flightOffers[0]->__toString()
        );
    }
}
