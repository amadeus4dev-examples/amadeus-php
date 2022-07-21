<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\FlightBaggageAllowance;
use Amadeus\Resources\FlightFareDetailsBySegment;
use Amadeus\Resources\FlightFee;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\FlightItineraries;
use Amadeus\Resources\FlightPrice;
use Amadeus\Resources\FlightPricingOptions;
use Amadeus\Resources\TravelerPricing;
use Amadeus\Shopping\FlightOffers;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\FlightOffers
 * @covers \Amadeus\Shopping\FlightOffers\Pricing
 * @covers \Amadeus\Shopping\FlightOffers\Prediction
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightOffer
 * @covers \Amadeus\Resources\FlightItineraries
 * @covers \Amadeus\Resources\FlightExtendedSegment
 * @covers \Amadeus\Resources\FlightPrice
 * @covers \Amadeus\Resources\FlightFee
 * @covers \Amadeus\Resources\FlightPricingOptions
 * @covers \Amadeus\Resources\TravelerPricing
 * @covers \Amadeus\Resources\FlightFareDetailsBySegment
 * @covers \Amadeus\Resources\FlightBaggageAllowance
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
 */
final class FlightOffersTest extends TestCase
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
    public function test_given_client_when_call_flight_offers_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_offers_get_response_ok.json"
        );
        $data4Get = json_decode($fileContent)->{'data'};
        $response4Get = $this->createMock(Response::class);
        $response4Get->expects($this->any())
            ->method("getData")
            ->willReturn($data4Get);

        $fileContent2 = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_offers_post_response_ok.json"
        );
        $data4Post = json_decode($fileContent2)->{'data'};
        $response4Post = $this->createMock(Response::class);
        $response4Post->expects($this->any())
            ->method("getData")
            ->willReturn($data4Post);


        // Given Get
        $params = array(
            "originLocationCode" => "SYD",
            "destinationCode" => "BKK",
            "departureDate" => "2021-11-01",
            "max" => 2
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v2/shopping/flight-offers", $params)
            ->willReturn($response4Get);

        // Given Post
        $body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_availabilities_post_request_ok.json"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v2/shopping/flight-offers", $body)
            ->willReturn($response4Post);

        // When
        $flightOffersSearch = new FlightOffers($this->amadeus);
        $flightOffersGet = $flightOffersSearch->get($params);
        $flightOffersPost = $flightOffersSearch->post($body);

        // Then
        $this->assertNotNull($flightOffersGet);
        $this->assertEquals(2, sizeof($flightOffersGet));
        $this->assertNotNull($flightOffersPost);
        $this->assertEquals(2, sizeof($flightOffersPost));

        // Resources
        // FlightOffer
        $this->assertTrue($flightOffersGet[0] instanceof FlightOffer);
        $this->assertEquals("flight-offer", $flightOffersGet[0]->getType());
        $this->assertEquals("1", $flightOffersGet[0]->getId());
        $this->assertEquals("GDS", $flightOffersGet[0]->getSource());
        $this->assertEquals(false, $flightOffersGet[0]->getInstantTicketingRequired());
        $this->assertEquals(false, $flightOffersGet[0]->getNonHomogeneous());
        $this->assertEquals(false, $flightOffersGet[0]->getOneWay());
        $this->assertEquals(null, $flightOffersGet[0]->getPaymentCardRequired());
        $this->assertEquals("2021-11-01", $flightOffersGet[0]->getLastTicketingDate());
        $this->assertEquals(9, $flightOffersGet[0]->getNumberOfBookableSeats());
        $this->assertEquals(array("PR"), $flightOffersGet[0]->getValidatingAirlineCodes());

        // Itineraries
        $itineraries = $flightOffersGet[0]->getItineraries();
        $this->assertTrue($itineraries[0] instanceof FlightItineraries);
        $this->assertEquals("PT14H15M", $itineraries[0]->getDuration());

        // ExtendedSegment
        $this->assertNotNull($itineraries[0]->getSegments());

        // Price
        $price = $flightOffersGet[0]->getPrice();
        $this->assertTrue($price instanceof FlightPrice);
        $this->assertEquals("355.34", $price->getGrandTotal());
        $this->assertEquals("EUR", $price->getCurrency());
        $this->assertEquals("355.34", $price->getTotal());
        $this->assertEquals("255.00", $price->getBase());

        // Fee
        $fees = $price->getFees();
        $this->assertTrue($fees[0] instanceof FlightFee);
        $this->assertEquals("0.00", $fees[0]->getAmount());
        $this->assertEquals("SUPPLIER", $fees[0]->getType());

        // PricingOptions
        $pricingOptions = $flightOffersGet[0]->getPricingOptions();
        $this->assertTrue($pricingOptions instanceof FlightPricingOptions);
        $this->assertEquals(array("PUBLISHED"), $pricingOptions->getFareType());
        $this->assertEquals(true, $pricingOptions->getIncludedCheckedBagsOnly());

        // TravelerPricing
        $travelerPricings = $flightOffersGet[0]->getTravelerPricings();
        $this->assertTrue($travelerPricings[0] instanceof TravelerPricing);
        $this->assertEquals("1", $travelerPricings[0]->getTravelerId());
        $this->assertEquals("STANDARD", $travelerPricings[0]->getFareOption());
        $this->assertEquals("ADULT", $travelerPricings[0]->getTravelerType());
        $this->assertNotNull($travelerPricings[0]->getPrice());

        // FareDetailsBySegment
        $fareDetailsBySegment = $travelerPricings[0]->getFareDetailsBySegment();
        $this->assertTrue($fareDetailsBySegment[0] instanceof FlightFareDetailsBySegment);
        $this->assertEquals("1", $fareDetailsBySegment[0]->getSegmentId());
        $this->assertEquals("ECONOMY", $fareDetailsBySegment[0]->getCabin());
        $this->assertEquals("EOBAU", $fareDetailsBySegment[0]->getFareBasis());
        $this->assertEquals("E", $fareDetailsBySegment[0]->getClass());

        // BaggageAllowance
        $includedCheckedBags = $fareDetailsBySegment[0]->getIncludedCheckedBags();
        $this->assertTrue($includedCheckedBags instanceof FlightBaggageAllowance);
        $this->assertEquals(25, $includedCheckedBags->getWeight());
        $this->assertEquals("KG", $includedCheckedBags->getWeightUnit());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]),
            $flightOffersGet[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'itineraries'}[0]),
            $itineraries[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'price'}),
            $price->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'price'}->{'fees'}[0]),
            $fees[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'pricingOptions'}),
            $pricingOptions->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'travelerPricings'}[0]),
            $travelerPricings[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'travelerPricings'}[0]->{'fareDetailsBySegment'}[0]),
            $fareDetailsBySegment[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data4Get[0]->{'travelerPricings'}[0]->{'fareDetailsBySegment'}[0]->{'includedCheckedBags'}),
            $includedCheckedBags->__toString()
        );
    }
}
