<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Resources\AircraftEquipment;
use Amadeus\Resources\AvailabilityClass;
use Amadeus\Resources\ExtendedSegment;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\FlightEndpoint;
use Amadeus\Resources\OperatingFlight;
use Amadeus\Resources\Resource;
use Amadeus\Resources\TourAllotment;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightAvailability
 * @covers \Amadeus\Resources\ExtendedSegment
 * @covers \Amadeus\Resources\FlightEndpoint
 * @covers \Amadeus\Resources\AircraftEquipment
 * @covers \Amadeus\Resources\OperatingFlight
 * @covers \Amadeus\Resources\AvailabilityClass
 * @covers \Amadeus\Resources\TourAllotment
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
 */
final class FlightAvailabilityTest extends TestCase
{
    private iterable $flightAvailabilities;
    private iterable $segments;
    private object $departure;
    private object $arrival;
    private object $aircraft;
    private object $operating;
    private iterable $availabilityClasses;
    private object $tourAllotment;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $body =
            '{
              "meta": {
                "count": 4
              },
              "data": [
                {
                  "type": "flight-availability",
                  "id": "1",
                  "source": "LTC",
                  "duration": "PT1H20M",
                  "segments": [
                    {
                      "departure": {
                        "iataCode": "CDG",
                        "terminal": "2D",
                        "at": "2020-10-15T09:50:00"
                      },
                      "arrival": {
                        "iataCode": "STN",
                        "at": "2020-10-15T10:10:00"
                      },
                      "carrierCode": "U2",
                      "number": "3152",
                      "aircraft": {
                        "code": "319"
                      },
                      "operating": {
                        "carrierCode": "U2"
                      },
                      "duration": "PT1H20M",
                      "id": "1",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "availabilityClasses": [
                        {
                          "availability": "9",
                          "class": "A",
                          "closedStatus": "WAITLIST_OPEN"
                        },
                        {
                          "availability": "7",
                          "class": "B"
                        },
                        {
                          "availability": "9",
                          "class": "C",
                          "tourAllotment": {
                            "mode": "FREE",
                            "tourReference": "HOLIDAY_TOUR",
                            "remainingSeats": "4"
                          }
                        },
                        {
                          "availability": "4",
                          "class": "D",
                          "closedStatus": "ON_REQUEST"
                        }
                      ]
                    }
                  ]
                },
                {
                  "type": "flight-availability",
                  "id": "2",
                  "source": "GDS",
                  "duration": "PT3H10M",
                  "segments": [
                    {
                      "departure": {
                        "iataCode": "CDG",
                        "terminal": "2F",
                        "at": "2020-10-15T14:30:00"
                      },
                      "arrival": {
                        "iataCode": "AMS",
                        "at": "2020-10-15T15:45:00"
                      },
                      "carrierCode": "KL",
                      "number": "1234",
                      "aircraft": {
                        "code": "73H"
                      },
                      "operating": {
                        "carrierCode": "KL"
                      },
                      "duration": "PT1H15M",
                      "id": "3",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "availabilityClasses": [
                        {
                          "availability": "2",
                          "class": "A"
                        },
                        {
                          "availability": "7",
                          "class": "B"
                        },
                        {
                          "availability": "3",
                          "class": "C"
                        },
                        {
                          "availability": "4",
                          "class": "D"
                        }
                      ]
                    },
                    {
                      "departure": {
                        "iataCode": "AMS",
                        "at": "2020-10-15T16:35:00"
                      },
                      "arrival": {
                        "iataCode": "LCY",
                        "at": "2020-10-15T16:40:00"
                      },
                      "carrierCode": "KL",
                      "number": "989",
                      "aircraft": {
                        "code": "E90"
                      },
                      "operating": {
                        "carrierCode": "KL"
                      },
                      "duration": "PT1H5M",
                      "id": "4",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "availabilityClasses": [
                        {
                          "availability": "9",
                          "class": "A"
                        },
                        {
                          "availability": "7",
                          "class": "B"
                        },
                        {
                          "availability": "9",
                          "class": "C"
                        },
                        {
                          "availability": "4",
                          "class": "D"
                        }
                      ]
                    }
                  ]
                },
                {
                  "type": "flight-availability",
                  "id": "3",
                  "source": "GDS",
                  "duration": "PT1H10M",
                  "segments": [
                    {
                      "departure": {
                        "iataCode": "LHR",
                        "terminal": "5",
                        "at": "2020-10-16T19:40:00"
                      },
                      "arrival": {
                        "iataCode": "CDG",
                        "terminal": "2A",
                        "at": "2020-10-16T21:50:00"
                      },
                      "carrierCode": "BA",
                      "number": "329",
                      "aircraft": {
                        "code": "319"
                      },
                      "operating": {
                        "carrierCode": "BA"
                      },
                      "duration": "PT1H10M",
                      "id": "2",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "closedStatus": "CANCELLED"
                    }
                  ]
                },
                {
                  "type": "flight-availability",
                  "id": "4",
                  "source": "LTC",
                  "duration": "PT1H20M",
                  "segments": [
                    {
                      "departure": {
                        "iataCode": "STN",
                        "at": "2020-10-16T19:40:00"
                      },
                      "arrival": {
                        "iataCode": "CDG",
                        "terminal": "2D",
                        "at": "2020-10-16T22:00:00"
                      },
                      "carrierCode": "U2",
                      "number": "330",
                      "aircraft": {
                        "code": "319"
                      },
                      "operating": {
                        "carrierCode": "U2"
                      },
                      "duration": "PT1H20M",
                      "id": "5",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "availabilityClasses": [
                        {
                          "availability": "4",
                          "class": "C"
                        },
                        {
                          "availability": "9",
                          "class": "Y"
                        }
                      ]
                    }
                  ]
                }
              ],
              "dictionaries": {
                "locations": {
                  "LCY": {
                    "cityCode": "LON",
                    "countryCode": "GB"
                  },
                  "CDG": {
                    "cityCode": "PAR",
                    "countryCode": "FR"
                  },
                  "LHR": {
                    "cityCode": "LON",
                    "countryCode": "GB"
                  },
                  "AMS": {
                    "cityCode": "AMS",
                    "countryCode": "NL"
                  },
                  "STN": {
                    "cityCode": "LON",
                    "countryCode": "GB"
                  }
                },
                "aircraft": {
                  "319": "AIRBUS INDUSTRIE A319",
                  "73H": "BOEING 737-800 (WINGLETS)",
                  "E90": "EMBRAER 190"
                },
                "carriers": {
                  "KL": "KLM ROYAL DUTCH AIRLINES",
                  "U2": "EASYJET",
                  "BA": "BRITISH AIRWAYS"
                }
              }
            }';

        $arrayData = json_decode($body)->{'data'};
        $this->flightAvailabilities = Resource::toResourceArray($arrayData, FlightAvailability::class);
        $this->segments = $this->flightAvailabilities[0]->getSegments();
        $this->departure = $this->segments[0]->getDeparture();
        $this->arrival = $this->segments[0]->getArrival();
        $this->aircraft = $this->segments[0]->getAircraft();
        $this->operating = $this->segments[0]->getOperating();
        $this->availabilityClasses = $this->segments[0]->getAvailabilityClasses();
        $this->tourAllotment = $this->availabilityClasses[2]->getTourAllotment();
    }

    public function testInitialize(): void
    {
        $this->assertTrue($this->flightAvailabilities[0] instanceof FlightAvailability);
        $this->assertTrue($this->segments[0] instanceof ExtendedSegment);
        $this->assertTrue($this->departure instanceof FlightEndpoint);
        $this->assertTrue($this->arrival instanceof FlightEndpoint);
        $this->assertTrue($this->aircraft instanceof AircraftEquipment);
        $this->assertTrue($this->operating instanceof OperatingFlight);
        $this->assertTrue($this->availabilityClasses[0] instanceof AvailabilityClass);
        $this->assertTrue($this->tourAllotment instanceof TourAllotment);
    }

    public function testGetSimpleValue(): void
    {
        $this->assertEquals("flight-availability", $this->flightAvailabilities[0]->getType());
        $this->assertEquals("1", $this->flightAvailabilities[0]->getId());
        $this->assertEquals(null, $this->flightAvailabilities[0]->getOriginDestinationId());
        $this->assertEquals("LTC", $this->flightAvailabilities[0]->getSource());
        $this->assertEquals(null, $this->flightAvailabilities[0]->getInstantTicketRequired());
        $this->assertEquals(null, $this->flightAvailabilities[0]->getPaymentCardRequired());
        $this->assertEquals("PT1H20M", $this->flightAvailabilities[0]->getDuration());
    }

    public function testGetSegments(): void
    {
        $this->assertEquals("1", $this->segments[0]->getId());
        $this->assertEquals(0, $this->segments[0]->getNumberOfStops());
        $this->assertEquals(false, $this->segments[0]->getBlacklistedInEU());
        $this->assertEquals("U2", $this->segments[0]->getCarrierCode());
        $this->assertEquals("3152", $this->segments[0]->getNumber());
    }

    public function testGetDeparture(): void
    {
        $this->assertEquals("CDG", $this->departure->getIataCode());
        $this->assertEquals("2D", $this->departure->getTerminal());
        $this->assertEquals("2020-10-15T09:50:00", $this->departure->getAt());
    }

    public function testGetAircraft(): void
    {
        $this->assertEquals("319", $this->aircraft->getCode());
    }

    public function testGetOperating(): void
    {
        $this->assertEquals("U2", $this->operating->getCarrierCode());
    }

    public function testGetAvailabilityClasses(): void
    {
        $this->assertEquals(null, $this->availabilityClasses[0]->getNumberOfBookableSeats());
        $this->assertEquals("A", $this->availabilityClasses[0]->getClass());
        $this->assertEquals("WAITLIST_OPEN", $this->availabilityClasses[0]->getClosedStatus());
    }

    public function testGetTourAllotment(): void
    {
        $this->assertEquals(null, $this->tourAllotment->getTourName());
        $this->assertEquals("FREE", $this->tourAllotment->getMode());
        $this->assertEquals("HOLIDAY_TOUR", $this->tourAllotment->getTourReference());
        $this->assertEquals("4", $this->tourAllotment->getRemainingSeats());
    }
}
