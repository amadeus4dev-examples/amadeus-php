<?php

declare(strict_types=1);

namespace Amadeus\Tests\Resources;

use Amadeus\Resources\AircraftEquipment;
use Amadeus\Resources\AvailabilityClass;
use Amadeus\Resources\Co2Emission;
use Amadeus\Resources\ExtendedSegment;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\FlightEndpoint;
use Amadeus\Resources\FlightStop;
use Amadeus\Resources\OperatingFlight;
use Amadeus\Resources\Resource;
use Amadeus\Resources\TourAllotment;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightAvailability
 * @covers \Amadeus\Resources\ExtendedSegment
 * @covers \Amadeus\Resources\AvailabilityClass
 * @covers \Amadeus\Resources\TourAllotment
 * @covers \Amadeus\Resources\Co2Emission
 * @covers \Amadeus\Resources\FlightEndpoint
 * @covers \Amadeus\Resources\AircraftEquipment
 * @covers \Amadeus\Resources\OperatingFlight
 * @covers \Amadeus\Resources\FlightStop
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
 */
final class FlightAvailabilityTest extends TestCase
{
    private array $data;
    private FlightAvailability $flightAvailability;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $body =
            '{
              "data": [
                {
                  "type": "flight-availability",
                  "id": "1",
                  "originDestinationId": "1",
                  "source": "GDS",
                  "instantTicketingRequired": false,
                  "paymentCardRequired": false,
                  "duration": "PT2H10M",
                  "segments": [
                    {
                      "closedStatus": "CANCELLED",
                      "availabilityClasses": [
                        {
                          "numberOfBookableSeats": 9,
                          "class": "A",
                          "closedStatus": "WAITLIST_OPEN",
                          "tourAllotment": {
                            "tourName": "TOUR_NAME",
                            "tourReference": "HOLIDAY_TOUR",
                            "mode": "FREE",
                            "remainingSeats": "9"
                          }
                        }
                      ],
                      "id": "1",
                      "numberOfStops": 0,
                      "blacklistedInEU": false,
                      "co2Emissions": [ 
                        {
                          "weight": 90,
                          "weightUnit": "KG",
                          "cabin": "PREMIUM_ECONOMY"
                        }
                      ],
                      "departure": {
                        "iataCode": "JFK",
                        "terminal": "T2",
                        "at": "2017-10-23T20:00:00"
                      },
                      "arrival": {
                        "iataCode": "JFK",
                        "terminal": "T2",
                        "at": "2017-10-23T20:00:00"
                      },
                      "carrierCode": "DL",
                      "number": "212",
                      "aircraft": {
                        "code": "318"
                      },
                      "operating": {
                        "carrierCode": "DL"
                      },
                      "duration": "PT2H10M",
                      "stops":[ 
                        {
                          "iataCode": "JFK",
                          "duration": "PT2H10M",
                          "arrivalAt": "2017-10-23T20:00:00",
                          "departureAt": "2017-10-23T20:00:00"
                        }
                      ]
                    }
                  ]
                }
              ]
            }';

        $this->data = json_decode($body)->{'data'};
        $this->flightAvailability = Resource::toResourceArray($this->data, FlightAvailability::class)[0];
    }

    public function testGetSimpleValue(): void
    {
        $this->assertEquals("flight-availability", $this->flightAvailability->getType());
        $this->assertEquals("1", $this->flightAvailability->getId());
        $this->assertEquals("1", $this->flightAvailability->getOriginDestinationId());
        $this->assertEquals("GDS", $this->flightAvailability->getSource());
        $this->assertEquals(false, $this->flightAvailability->getInstantTicketingRequired());
        $this->assertEquals(false, $this->flightAvailability->getPaymentCardRequired());
        $this->assertEquals("PT2H10M", $this->flightAvailability->getDuration());
    }

    public function testGetExtendedSegments(): void
    {
        $segments = $this->flightAvailability->getSegments();
        $this->assertTrue($segments[0] instanceof ExtendedSegment);
        $this->assertEquals("CANCELLED", $segments[0]->getClosedStatus());
        $this->assertEquals("1", $segments[0]->getId());
        $this->assertEquals(0, $segments[0]->getNumberOfStops());
        $this->assertEquals(false, $segments[0]->getBlacklistedInEU());
        $this->assertEquals("DL", $segments[0]->getCarrierCode());
        $this->assertEquals("212", $segments[0]->getNumber());
        $this->assertEquals("PT2H10M", $segments[0]->getDuration());
    }

    public function testGetAvailabilityClasses(): void
    {
        $availabilityClasses = $this->flightAvailability->getSegments()[0]->getAvailabilityClasses();
        $this->assertTrue($availabilityClasses[0] instanceof AvailabilityClass);
        $this->assertEquals(9, $availabilityClasses[0]->getNumberOfBookableSeats());
        $this->assertEquals("A", $availabilityClasses[0]->getClass());
        $this->assertEquals("WAITLIST_OPEN", $availabilityClasses[0]->getClosedStatus());

        $tourAllotment = $availabilityClasses[0]->getTourAllotment();
        $this->assertTrue($tourAllotment instanceof TourAllotment);
        $this->assertEquals("TOUR_NAME", $tourAllotment->getTourName());
        $this->assertEquals("HOLIDAY_TOUR", $tourAllotment->getTourReference());
        $this->assertEquals("FREE", $tourAllotment->getMode());
        $this->assertEquals("9", $tourAllotment->getRemainingSeats());
    }

    public function testGetCo2Emissions(): void
    {
        $co2Emissions = $this->flightAvailability->getSegments()[0]->getCo2Emissions();
        $this->assertTrue($co2Emissions[0] instanceof Co2Emission);
        $this->assertEquals(90, $co2Emissions[0]->getWeight());
        $this->assertEquals("KG", $co2Emissions[0]->getWeightUnit());
        $this->assertEquals("PREMIUM_ECONOMY", $co2Emissions[0]->getCabin());
    }

    public function testGetDeparture(): void
    {
        $departure = $this->flightAvailability->getSegments()[0]->getDeparture();
        $this->assertTrue($departure instanceof FlightEndpoint);
        $this->assertEquals("JFK", $departure->getIataCode());
        $this->assertEquals("T2", $departure->getTerminal());
        $this->assertEquals("2017-10-23T20:00:00", $departure->getAt());
    }

    public function testGetArrival(): void
    {
        $arrival = $this->flightAvailability->getSegments()[0]->getArrival();
        $this->assertTrue($arrival instanceof FlightEndpoint);
        $this->assertEquals("JFK", $arrival->getIataCode());
        $this->assertEquals("T2", $arrival->getTerminal());
        $this->assertEquals("2017-10-23T20:00:00", $arrival->getAt());
    }

    public function testGetAircraft(): void
    {
        $aircraft = $this->flightAvailability->getSegments()[0]->getAircraft();
        $this->assertTrue($aircraft instanceof AircraftEquipment);
        $this->assertEquals("318", $aircraft->getCode());
    }

    public function testGetOperating(): void
    {
        $operating = $this->flightAvailability->getSegments()[0]->getOperating();
        $this->assertTrue($operating instanceof OperatingFlight);
        $this->assertEquals("DL", $operating->getCarrierCode());
    }

    public function testGetStops(): void
    {
        $stops = $this->flightAvailability->getSegments()[0]->getStops();
        $this->assertTrue($stops[0] instanceof FlightStop);
        $this->assertEquals("JFK", $stops[0]->getIataCode());
        $this->assertEquals("PT2H10M", $stops[0]->getDuration());
        $this->assertEquals("2017-10-23T20:00:00", $stops[0]->getArrivalAt());
        $this->assertEquals("2017-10-23T20:00:00", $stops[0]->getDepartureAt());
    }

    public function testToString(): void
    {
        $this->assertEquals(
            json_encode($this->data[0]),
            $this->flightAvailability->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]),
            $this->flightAvailability->getSegments()[0]->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'availabilityClasses'}[0]),
            $this->flightAvailability->getSegments()[0]->getAvailabilityClasses()[0]->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'availabilityClasses'}[0]->{'tourAllotment'}),
            $this->flightAvailability->getSegments()[0]->getAvailabilityClasses()[0]->getTourAllotment()->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'co2Emissions'}[0]),
            $this->flightAvailability->getSegments()[0]->getCo2Emissions()[0]->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'departure'}),
            $this->flightAvailability->getSegments()[0]->getDeparture()->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'arrival'}),
            $this->flightAvailability->getSegments()[0]->getArrival()->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'aircraft'}),
            $this->flightAvailability->getSegments()[0]->getAircraft()->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'operating'}),
            $this->flightAvailability->getSegments()[0]->getOperating()->__toString()
        );
        $this->assertEquals(
            json_encode($this->data[0]->{'segments'}[0]->{'stops'}[0]),
            $this->flightAvailability->getSegments()[0]->getStops()[0]->__toString()
        );
    }
}
