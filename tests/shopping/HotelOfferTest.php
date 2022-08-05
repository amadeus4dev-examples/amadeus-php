<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\HotelContent;
use Amadeus\Resources\HotelOfferAveragePrice;
use Amadeus\Resources\HotelOffers;
use Amadeus\Resources\HotelOfferTax;
use Amadeus\Resources\HotelProductCancellationPolicy;
use Amadeus\Resources\HotelProductCheckInOutPolicy;
use Amadeus\Resources\HotelProductCommission;
use Amadeus\Resources\HotelProductDepositPolicy;
use Amadeus\Resources\HotelProductEstimatedRoomType;
use Amadeus\Resources\HotelProductGuaranteePolicy;
use Amadeus\Resources\HotelProductGuests;
use Amadeus\Resources\HotelProductHoldPolicy;
use Amadeus\Resources\HotelProductHotelPrice;
use Amadeus\Resources\HotelProductPaymentPolicy;
use Amadeus\Resources\HotelProductPolicyDetails;
use Amadeus\Resources\HotelProductPriceVariation;
use Amadeus\Resources\HotelProductPriceVariations;
use Amadeus\Resources\HotelProductRateFamily;
use Amadeus\Resources\HotelProductRoomDetails;
use Amadeus\Resources\Markup;
use Amadeus\Resources\QualifiedFreeText;
use Amadeus\Shopping\HotelOffer;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\HotelOffer
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\HotelContent
 * @covers \Amadeus\Resources\HotelOffer
 * @covers \Amadeus\Resources\HotelOfferAveragePrice
 * @covers \Amadeus\Resources\HotelOffers
 * @covers \Amadeus\Resources\HotelOfferTax
 * @covers \Amadeus\Resources\HotelProductCancellationPolicy
 * @covers \Amadeus\Resources\HotelProductCheckInOutPolicy
 * @covers \Amadeus\Resources\HotelProductCommission
 * @covers \Amadeus\Resources\HotelProductDepositPolicy
 * @covers \Amadeus\Resources\HotelProductEstimatedRoomType
 * @covers \Amadeus\Resources\HotelProductGuaranteePolicy
 * @covers \Amadeus\Resources\HotelProductGuests
 * @covers \Amadeus\Resources\HotelProductHoldPolicy
 * @covers \Amadeus\Resources\HotelProductHotelPrice
 * @covers \Amadeus\Resources\HotelProductPaymentPolicy
 * @covers \Amadeus\Resources\HotelProductPolicyDetails
 * @covers \Amadeus\Resources\HotelProductPriceVariation
 * @covers \Amadeus\Resources\HotelProductPriceVariations
 * @covers \Amadeus\Resources\HotelProductRateFamily
 * @covers \Amadeus\Resources\HotelProductRoomDetails
 * @covers \Amadeus\Resources\Markup
 * @covers \Amadeus\Resources\QualifiedFreeText
 *
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
 */
final class HotelOfferTest extends TestCase
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
    public function test_given_client_when_call_hotel_offer_then_ok(): array
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "hotel_offer_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = "63A93695B58821ABB0EC2B33FE9FAB24D72BF34B1BD7D707293763D8D9378FC3";
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithOnlyPath")
            ->with("/v3/shopping/hotel-offers"."/". $params)
            ->willReturn($response);

        // When
        $hotelOffers = (new HotelOffer($this->amadeus, $params))->get();

        // Then
        $this->assertNotNull($hotelOffers);

        return ["offerId"=>$params, "data"=>$data, "hotelOffers"=>$hotelOffers];
    }

    /**
     * @param array $fixtures
     * @depends test_given_client_when_call_hotel_offer_then_ok
     */
    public function test_returned_resource_given_client_when_call_hotel_offer_then_ok(array $fixtures): void
    {
        $data = $fixtures['data'];
        $hotelOffers = $fixtures['hotelOffers'];
        $offerId = $fixtures['offerId'];

        // Resource
        // HotelOffers
        // See HotelOffersTest.php
        $this->assertTrue($hotelOffers instanceof HotelOffers);

        // HotelContent
        // See HotelOffersTest.php
        $hotel = $hotelOffers->getHotel();
        $this->assertNotNull($hotel);
        $this->assertTrue($hotel instanceof HotelContent);

        // HotelOffer
        $hotelOffer = $hotelOffers->getOffers()[0];
        $this->assertTrue($hotelOffer instanceof \Amadeus\Resources\HotelOffer);
        $this->assertEquals("hotel-offer", $hotelOffer->getType());
        $this->assertEquals($offerId, $hotelOffer->getId());
        $this->assertEquals("2020-12-30", $hotelOffer->getCheckInDate());
        $this->assertEquals("2020-12-31", $hotelOffer->getCheckOutDate());
        $this->assertEquals("1", $hotelOffer->getRoomQuantity());
        $this->assertEquals("RAC", $hotelOffer->getRateCode());
        $this->assertEquals("FAMILY_PLAN", $hotelOffer->getCategory());
        $this->assertEquals("ROOM_ONLY", $hotelOffer->getBoardType());
        $this->assertEquals(
            "https://test.travel.api.amadeus.com/v2/shopping/hotel-offers/" . $offerId,
            $hotelOffer->getSelf()
        );

        // HotelProductRateFamily
        $rateFamilyEstimated = $hotelOffer->getRateFamilyEstimated();
        $this->assertTrue($rateFamilyEstimated instanceof HotelProductRateFamily);
        $this->assertEquals("string", $rateFamilyEstimated->getCode());
        $this->assertEquals("string", $rateFamilyEstimated->getType());

        // QualifiedFreeText
        $description = $hotelOffer->getDescription();
        $this->assertTrue($description instanceof QualifiedFreeText);
        $this->assertEquals("A description", $description->getText());
        $this->assertEquals("fr-FR", $description->getLang());

        // HotelProductCommission
        $commission = $hotelOffer->getCommission();
        $this->assertTrue($commission instanceof HotelProductCommission);
        $this->assertEquals("string", $commission->getPercentage());
        $this->assertEquals("string", $commission->getAmount());
        $this->assertNotNull($commission->getDescription());

        // HotelProductRoomDetails
        $room = $hotelOffer->getRoom();
        $this->assertTrue($room instanceof HotelProductRoomDetails);
        $this->assertEquals("string", $room->getType());
        $this->assertNotNull($room->getDescription());

        // HotelProductEstimatedRoomType
        $typeEstimated = $room->getTypeEstimated();
        $this->assertTrue($typeEstimated instanceof HotelProductEstimatedRoomType);
        $this->assertEquals("string", $typeEstimated->getCategory());
        $this->assertEquals(0, $typeEstimated->getBeds());
        $this->assertEquals("string", $typeEstimated->getBedType());

        // HotelProductGuests
        $guests = $hotelOffer->getGuests();
        $this->assertTrue($guests instanceof HotelProductGuests);
        $this->assertEquals(2, $guests->getAdults());
        $this->assertEquals([0], $guests->getChildAges());

        // HotelProductHotelPrice
        $price = $hotelOffer->getPrice();
        $this->assertTrue($price instanceof HotelProductHotelPrice);
        $this->assertEquals("string", $price->getCurrency());
        $this->assertEquals("string", $price->getSellingTotal());
        $this->assertEquals("string", $price->getTotal());
        $this->assertEquals("string", $price->getBase());

        // HotelOfferTax
        $taxes = $price->getTaxes();
        $this->assertTrue($taxes[0] instanceof HotelOfferTax);
        $this->assertEquals("string", $taxes[0]->getAmount());
        $this->assertEquals("string", $taxes[0]->getCurrency());
        $this->assertEquals("string", $taxes[0]->getCode());
        $this->assertEquals("string", $taxes[0]->getPercentage());
        $this->assertEquals(true, $taxes[0]->getIncluded());
        $this->assertEquals("string", $taxes[0]->getDescription());
        $this->assertEquals("string", $taxes[0]->getPricingFrequency());
        $this->assertEquals("string", $taxes[0]->getPricingMode());

        // Markup
        $markups = $price->getMarkups();
        $this->assertTrue($markups[0] instanceof Markup);
        $this->assertEquals("10", $markups[0]->getAmount());

        // HotelProductPriceVariations
        $variations = $price->getVariations();
        $this->assertTrue($variations instanceof HotelProductPriceVariations);

        // HotelOfferAveragePrice
        $average = $variations->getAverage();
        $this->assertTrue($average instanceof HotelOfferAveragePrice);
        $this->assertEquals("string", $average->getCurrency());
        $this->assertEquals("string", $average->getSellingTotal());
        $this->assertEquals("string", $average->getTotal());
        $this->assertEquals("string", $average->getBase());
        $this->assertNotNull($average->getMarkups());

        // HotelProductPriceVariation
        $changes = $variations->getChanges();
        $this->assertTrue($changes[0] instanceof HotelProductPriceVariation);
        $this->assertEquals("2022-06-20", $changes[0]->getStartDate());
        $this->assertEquals("2022-06-20", $changes[0]->getEndDate());
        $this->assertEquals("string", $changes[0]->getCurrency());
        $this->assertEquals("string", $changes[0]->getSellingTotal());
        $this->assertEquals("string", $changes[0]->getTotal());
        $this->assertEquals("string", $changes[0]->getBase());
        $this->assertNotNull($changes[0]->getMarkups());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data),
            $hotelOffers->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'hotel'}),
            $hotel->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]),
            $hotelOffer->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'rateFamilyEstimated'}),
            $rateFamilyEstimated->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'description'}),
            $description->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'commission'}),
            $commission->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'room'}),
            $room->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'room'}->{'typeEstimated'}),
            $typeEstimated->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'guests'}),
            $guests->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}),
            $price->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}->{'taxes'}[0]),
            $taxes[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}->{'markups'}[0]),
            $markups[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}->{'variations'}),
            $variations->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}->{'variations'}->{'average'}),
            $average->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'price'}->{'variations'}->{'changes'}[0]),
            $changes[0]->__toString()
        );
    }

    /**
     * @param array $fixtures
     * @depends test_given_client_when_call_hotel_offer_then_ok
     */
    public function test_returned_resource2_given_client_when_call_hotel_offer_then_ok(array $fixtures): void
    {
        $data = $fixtures['data'];
        $hotelOffers = $fixtures['hotelOffers'];
        $hotelOffer = $hotelOffers->getOffers()[0];

        // HotelProductPolicyDetails
        $policies = $hotelOffer->getPolicies();
        $this->assertTrue($policies instanceof  HotelProductPolicyDetails);
        $this->assertEquals("GUARANTEE", $policies->getPaymentType());

        // HotelProductGuaranteePolicy
        $guarantee = $policies->getGuarantee();
        $this->assertTrue($guarantee instanceof HotelProductGuaranteePolicy);
        $this->assertNotNull($guarantee->getDescription());

        // HotelProductPaymentPolicy
        $acceptedPayments = $guarantee->getAcceptedPayments();
        $this->assertTrue($acceptedPayments instanceof HotelProductPaymentPolicy);
        $this->assertEquals(["string"], $acceptedPayments->getCreditCards());
        $this->assertEquals(["CREDIT_CARD"], $acceptedPayments->getMethods());

        // HotelProductDepositPolicy
        $deposit = $policies->getDeposit();
        $this->assertTrue($deposit instanceof HotelProductDepositPolicy);
        $this->assertEquals("string", $deposit->getAmount());
        $this->assertEquals("2022-06-20T12:10:33.006Z", $deposit->getDeadline());
        $this->assertNotNull($deposit->getDescription());
        $this->assertNotNull($deposit->getAcceptedPayments());

        $prepay = $policies->getPrepay();
        $this->assertNotNull($prepay);
        $this->assertTrue($prepay instanceof HotelProductDepositPolicy);

        // HotelProductHoldPolicy
        $holdTime = $policies->getHoldTime();
        $this->assertTrue($holdTime instanceof HotelProductHoldPolicy);
        $this->assertEquals("2022-06-20T12:10:33.006Z", $holdTime->getDeadline());

        // HotelProductCancellationPolicy
        $cancellation = $policies->getCancellation();
        $this->assertTrue($cancellation instanceof HotelProductCancellationPolicy);
        $this->assertEquals("FULL_STAY", $cancellation->getType());
        $this->assertEquals("string", $cancellation->getAmount());
        $this->assertEquals(0, $cancellation->getNumberOfNights());
        $this->assertEquals("string", $cancellation->getPercentage());
        $this->assertEquals("2022-06-20T12:10:33.006Z", $cancellation->getDeadline());
        $this->assertNotNull($cancellation->getDescription());

        // HotelProductCheckInOutPolicy
        $checkInOut = $policies->getCheckInOut();
        $this->assertTrue($checkInOut instanceof HotelProductCheckInOutPolicy);
        $this->assertEquals("13:00:00", $checkInOut->getCheckIn());
        $this->assertNotNull($checkInOut->getCheckInDescription());
        $this->assertEquals("11:00:00", $checkInOut->getCheckOut());
        $this->assertNotNull($checkInOut->getCheckOutDescription());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}),
            $policies->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'guarantee'}),
            $guarantee->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'guarantee'}->{'acceptedPayments'}),
            $acceptedPayments->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'deposit'}),
            $deposit->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'holdTime'}),
            $holdTime->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'cancellation'}),
            $cancellation->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data->{'offers'}[0]->{'policies'}->{'checkInOut'}),
            $checkInOut->__toString()
        );
    }
}
