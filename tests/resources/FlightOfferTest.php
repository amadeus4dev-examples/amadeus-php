<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Resources\BaggageAllowance;
use Amadeus\Resources\ExtendedSegment;
use Amadeus\Resources\FareDetailsBySegment;
use Amadeus\Resources\Fee;
use Amadeus\Resources\FlightOffer;
use Amadeus\Resources\Itineraries;
use Amadeus\Resources\Price;
use Amadeus\Resources\PricingOptions;
use Amadeus\Resources\Resource;
use Amadeus\Resources\TravelerPricing;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightOffer
 * @covers \Amadeus\Resources\ExtendedSegment
 * @covers \Amadeus\Resources\Itineraries
 * @covers \Amadeus\Resources\Fee
 * @covers \Amadeus\Resources\Price
 * @covers \Amadeus\Resources\PricingOptions
 * @covers \Amadeus\Resources\BaggageAllowance
 * @covers \Amadeus\Resources\FareDetailsBySegment
 * @covers \Amadeus\Resources\TravelerPricing
 */
final class FlightOfferTest extends TestCase
{
    private array $data;
    private FlightOffer $flightOffer;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $body =
            '{
              "data": [
                {
                  "type": "flight-offer",
                  "id": "1",
                  "source": "GDS",
                  "instantTicketingRequired": false,
                  "nonHomogeneous": false,
                  "oneWay": false,
                  "lastTicketingDate": "2022-11-01",
                  "numberOfBookableSeats": 9,
                  "itineraries": [
                    {
                      "duration": "PT14H15M",
                      "segments": [
                        {
                          "departure": {
                            "iataCode": "SYD",
                            "terminal": "1",
                            "at": "2022-11-01T11:35:00"
                          },
                          "arrival": {
                            "iataCode": "MNL",
                            "terminal": "2",
                            "at": "2022-11-01T16:50:00"
                          },
                          "carrierCode": "PR",
                          "number": "212",
                          "aircraft": {
                            "code": "333"
                          },
                          "operating": {
                            "carrierCode": "PR"
                          },
                          "duration": "PT8H15M",
                          "id": "1",
                          "numberOfStops": 0,
                          "blacklistedInEU": false
                        }
                      ]
                    }
                  ],
                  "price": {
                    "currency": "EUR",
                    "total": "1279.54",
                    "base": "844.00",
                    "fees": [
                      {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                      }
                    ],
                    "grandTotal": "1279.54"
                  },
                  "pricingOptions": {
                    "fareType": [
                      "PUBLISHED"
                    ],
                    "includedCheckedBagsOnly": true
                  },
                  "validatingAirlineCodes": [
                    "PR"
                  ],
                  "travelerPricings": [
                    {
                      "travelerId": "1",
                      "fareOption": "STANDARD",
                      "travelerType": "ADULT",
                      "price": {
                        "currency": "EUR",
                        "total": "639.77",
                        "base": "422.00"
                      },
                      "fareDetailsBySegment": [
                        {
                          "segmentId": "1",
                          "cabin": "ECONOMY",
                          "fareBasis": "TBAU",
                          "class": "T",
                          "includedCheckedBags": {
                            "weight": 30,
                            "weightUnit": "KG"
                          }
                        }
                      ]
                    }
                  ]
                }
              ]
            }';

        $this->data = json_decode($body)->{'data'};
        $this->flightOffer = Resource::toResourceArray($this->data, FlightOffer::class)[0];
    }

    public function testGetSimpleValue(): void
    {
        $this->assertEquals("flight-offer", $this->flightOffer->getType());
        $this->assertEquals("1", $this->flightOffer->getId());
        $this->assertEquals("GDS", $this->flightOffer->getSource());
        $this->assertEquals(false, $this->flightOffer->getInstantTicketingRequired());
        $this->assertEquals(false, $this->flightOffer->getNonHomogenous());
        $this->assertEquals(false, $this->flightOffer->getOneWay());
        $this->assertEquals("2022-11-01", $this->flightOffer->getLastTicketingDate());
        $this->assertEquals(9, $this->flightOffer->getNumberOfBookableSeats());
        $this->assertEquals("PR", $this->flightOffer->getValidatingAirlineCodes()[0]);
    }

    public function testGetItineraries(): void
    {
        $itineraries = $this->flightOffer->getItineraries();
        $this->assertTrue($itineraries[0] instanceof Itineraries);
        $this->assertEquals("PT14H15M", $itineraries[0]->getDuration());
        $this->assertTrue($itineraries[0]->getSegments()[0] instanceof ExtendedSegment);
    }

    public function testGetPrice(): void
    {
        $price = $this->flightOffer->getPrice();
        $this->assertTrue($price instanceof Price);
        $this->assertEquals("EUR", $price->getCurrency());
        $this->assertEquals("1279.54", $price->getTotal());
        $this->assertEquals("844.00", $price->getBase());

        $fees = $price->getFees();
        $this->assertTrue($fees[0] instanceof Fee);
        $this->assertEquals("0.00", $fees[0]->getAmount());
        $this->assertEquals("SUPPLIER", $fees[0]->getType());

        $this->assertEquals("1279.54", $price->getGrandTotal());
    }

    public function testGetPricingOptions(): void
    {
        $pricingOptions = $this->flightOffer->getPricingOptions();
        $this->assertTrue($pricingOptions instanceof PricingOptions);
        $this->assertEquals("PUBLISHED", $pricingOptions->getFareType()[0]);
        $this->assertEquals(true, $pricingOptions->getIncludedCheckedBagsOnly());
    }

    public function testGetTravelerPricings(): void
    {
        $travelerPricings = $this->flightOffer->getTravelerPricings();
        $this->assertTrue($travelerPricings[0] instanceof TravelerPricing);
        $this->assertEquals("1", $travelerPricings[0]->getTravelerId());
        $this->assertEquals("STANDARD", $travelerPricings[0]->getFareOption());
        $this->assertEquals("ADULT", $travelerPricings[0]->getTravelerType());
        $this->assertTrue($travelerPricings[0]->getPrice() instanceof Price);

        $fareDetailsBySegment = $travelerPricings[0]->getFareDetailsBySegment();
        $this->assertTrue($fareDetailsBySegment[0] instanceof FareDetailsBySegment);
        $this->assertEquals("1", $fareDetailsBySegment[0]->getSegmentId());
        $this->assertEquals("ECONOMY", $fareDetailsBySegment[0]->getCabin());
        $this->assertEquals("TBAU", $fareDetailsBySegment[0]->getFareBasis());
        $this->assertEquals("T", $fareDetailsBySegment[0]->getClass());

        $includedCheckedBags = $fareDetailsBySegment[0]->getIncludedCheckedBags();
        $this->assertTrue($includedCheckedBags instanceof BaggageAllowance);
        $this->assertEquals(30, $includedCheckedBags->getWeight());
        $this->assertEquals("KG", $includedCheckedBags->getWeightUnit());
        $this->assertEquals(null, $includedCheckedBags->getQuantity());
    }

}
