<?php

declare(strict_types=1);

namespace Amadeus\Tests\Schedule;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\AircraftEquipment;
use Amadeus\Resources\DatedFlight;
use Amadeus\Resources\DatedFlightLeg;
use Amadeus\Resources\DatedFlightSegment;
use Amadeus\Resources\DatedFlightSegmentPartnership;
use Amadeus\Resources\FlightDesignator;
use Amadeus\Resources\FlightPoint;
use Amadeus\Resources\FlightPointArrival;
use Amadeus\Resources\FlightPointDeparture;
use Amadeus\Resources\FlightPointTiming;
use Amadeus\Schedule\Flights;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Schedule\Flights
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\AircraftEquipment
 * @covers \Amadeus\Resources\DatedFlight
 * @covers \Amadeus\Resources\DatedFlightLeg
 * @covers \Amadeus\Resources\DatedFlightSegment
 * @covers \Amadeus\Resources\DatedFlightSegmentPartnership
 * @covers \Amadeus\Resources\FlightDesignator
 * @covers \Amadeus\Resources\FlightPoint
 * @covers \Amadeus\Resources\FlightPointArrival
 * @covers \Amadeus\Resources\FlightPointDeparture
 * @covers \Amadeus\Resources\FlightPointTiming
 * @covers \Amadeus\Schedule\Flights
 *
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/on-demand-flight-status/api-reference
 */
final class FlightsTest extends TestCase
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
    public function test_given_client_when_call_flights_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flights_get_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $params = ["carrierCode"=>"IB", "flightNumber"=>532, "scheduledDepartureDate"=>"2022-09-23"];
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("getWithArrayParams")
            ->with("/v2/schedule/flights", $params)
            ->willReturn($response);

        // When
        $flights = (new Flights($this->amadeus))->get($params);

        // Then
        $this->assertNotNull($flights);
        $this->assertEquals(1, sizeof($flights));

        // Resources
        // DatedFlight
        $this->assertTrue($flights[0] instanceof DatedFlight);
        $this->assertEquals("DatedFlight", $flights[0]->getType());
        $this->assertEquals("2022-09-23", $flights[0]->getScheduledDepartureDate());

        // FlightDesignator
        $flightDesignator = $flights[0]->getFlightDesignator();
        $this->assertTrue($flightDesignator instanceof FlightDesignator);
        $this->assertEquals("IB", $flightDesignator->getCarrierCode());
        $this->assertEquals(532, $flightDesignator->getFlightNumber());

        // FlightPoint
        $flightPoints = $flights[0]->getFlightPoints();
        $this->assertTrue($flightPoints[0] instanceof FlightPoint);
        $this->assertEquals("MAD", $flightPoints[0]->getIataCode());

        // FlightPointDeparture
        $departure = $flightPoints[0]->getDeparture();
        $this->assertTrue($departure instanceof FlightPointDeparture);

        // FlightPointArrival
        $arrival = $flightPoints[1]->getArrival();
        $this->assertTrue($arrival instanceof FlightPointArrival);

        // FlightPointTiming
        $departureTiming = $departure->getTimings();
        $arrivalTiming = $arrival->getTimings();
        $this->assertTrue($departureTiming[0] instanceof FlightPointTiming);
        $this->assertTrue($arrivalTiming[0] instanceof FlightPointTiming);
        $this->assertEquals("STD", $departureTiming[0]->getQualifier());
        $this->assertEquals("2022-09-23T11:45+02:00", $departureTiming[0]->getValue());

        // DatedFlightSegment
        $segments = $flights[0]->getSegments();
        $this->assertTrue($segments[0] instanceof DatedFlightSegment);
        $this->assertEquals("MAD", $segments[0]->getBoardPointIataCode());
        $this->assertEquals("VGO", $segments[0]->getOffPointIataCode());
        $this->assertEquals("PT1H10M", $segments[0]->getScheduledSegmentDuration());

        // DatedFlightSegmentPartnership
        $partnership = $segments[0]->getPartnership();
        $this->assertTrue($partnership instanceof DatedFlightSegmentPartnership);
        $this->assertTrue($partnership->getOperatingFlight() instanceof FlightDesignator);

        // DatedFlightLeg
        $legs = $flights[0]->getLegs();
        $this->assertTrue($legs[0] instanceof DatedFlightLeg);
        $this->assertEquals("MAD", $legs[0]->getBoardPointIataCode());
        $this->assertEquals("VGO", $legs[0]->getOffPointIataCode());
        $this->assertEquals("PT1H10M", $legs[0]->getScheduledLegDuration());

        // AircraftEquipment
        $aircraftEquipment = $legs[0]->getAircraftEquipment();
        $this->assertTrue($aircraftEquipment instanceof AircraftEquipment);
        $this->assertEquals("32A", $aircraftEquipment->getAircraftType());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $flights[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'flightDesignator'}),
            $flightDesignator->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'flightPoints'}[0]),
            $flightPoints[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'flightPoints'}[0]->{'departure'}),
            $departure->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'flightPoints'}[1]->{'arrival'}),
            $arrival->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'flightPoints'}[0]->{'departure'}->{'timings'}[0]),
            $departureTiming[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]),
            $segments[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'partnership'}),
            $partnership->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'legs'}[0]),
            $legs[0]->__toString()
        );
    }
}
