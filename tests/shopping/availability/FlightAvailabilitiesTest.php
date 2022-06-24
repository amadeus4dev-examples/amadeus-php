<?php

declare(strict_types=1);

namespace Amadeus\Tests\Shopping\Availability;

use Amadeus\Amadeus;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Response;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Resources\AircraftEquipment;
use Amadeus\Resources\FlightAvailabilityClass;
use Amadeus\Resources\Co2Emission;
use Amadeus\Resources\FlightExtendedSegment;
use Amadeus\Resources\FlightAvailability;
use Amadeus\Resources\FlightEndpoint;
use Amadeus\Resources\FlightStop;
use Amadeus\Resources\OperatingFlight;
use Amadeus\Resources\FlightTourAllotment;
use Amadeus\Shopping\Availability\FlightAvailabilities;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;

/**
 * This test covers the endpoint and its related returned resources.
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 *
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Resources\FlightAvailability
 * @covers \Amadeus\Resources\FlightExtendedSegment
 * @covers \Amadeus\Resources\FlightAvailabilityClass
 * @covers \Amadeus\Resources\FlightTourAllotment
 * @covers \Amadeus\Resources\Co2Emission
 * @covers \Amadeus\Resources\FlightEndpoint
 * @covers \Amadeus\Resources\AircraftEquipment
 * @covers \Amadeus\Resources\OperatingFlight
 * @covers \Amadeus\Resources\FlightStop
 *
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference
 */
final class FlightAvailabilitiesTest extends TestCase
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
    public function test_given_client_when_call_flight_availabilities_then_ok(): void
    {
        // Prepare Response
        $fileContent = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_availabilities_post_response_ok.json"
        );
        $data = json_decode($fileContent)->{'data'};
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getData")
            ->willReturn($data);

        // Given
        $body = PHPUnitUtil::readFile(
            PHPUnitUtil::RESOURCE_PATH_ROOT . "flight_availabilities_post_request_ok.json"
        );
        /* @phpstan-ignore-next-line */
        $this->client->expects($this->any())
            ->method("postWithStringBody")
            ->with("/v1/shopping/availability/flight-availabilities", $body)
            ->willReturn($response);

        // When
        $flightAvailabilitiesSearch = new FlightAvailabilities($this->amadeus);
        $flightAvailabilities = $flightAvailabilitiesSearch->post($body);

        // Then
        $this->assertNotNull($flightAvailabilities);
        $this->assertEquals(4, sizeof($flightAvailabilities));

        // Resources
        // FlightAvailability
        $this->assertTrue($flightAvailabilities[0] instanceof FlightAvailability);
        $this->assertEquals("flight-availability", $flightAvailabilities[0]->getType());
        $this->assertEquals("1", $flightAvailabilities[0]->getId());
        $this->assertEquals(null, $flightAvailabilities[0]->getOriginDestinationId());
        $this->assertEquals("LTC", $flightAvailabilities[0]->getSource());
        $this->assertEquals(false, $flightAvailabilities[0]->getInstantTicketingRequired());
        $this->assertEquals(false, $flightAvailabilities[0]->getPaymentCardRequired());
        $this->assertEquals("PT1H20M", $flightAvailabilities[0]->getDuration());

        // ExtendedSegment
        $segments = $flightAvailabilities[0]->getSegments();
        $this->assertTrue($segments[0] instanceof FlightExtendedSegment);
        $this->assertEquals(null, $segments[0]->getClosedStatus());
        $this->assertEquals("1", $segments[0]->getId());
        $this->assertEquals(0, $segments[0]->getNumberOfStops());
        $this->assertEquals(false, $segments[0]->getBlacklistedInEU());
        $this->assertEquals("U2", $segments[0]->getCarrierCode());
        $this->assertEquals("3152", $segments[0]->getNumber());
        $this->assertEquals("PT1H20M", $segments[0]->getDuration());

        // AvailabilityClass
        $availabilityClasses = $segments[0]->getAvailabilityClasses();
        $this->assertTrue($availabilityClasses[0] instanceof FlightAvailabilityClass);
        $this->assertEquals(9, $availabilityClasses[0]->getNumberOfBookableSeats());
        $this->assertEquals("A", $availabilityClasses[0]->getClass());
        $this->assertEquals("WAITLIST_OPEN", $availabilityClasses[0]->getClosedStatus());

        // TourAllotment
        $tourAllotment = $availabilityClasses[2]->getTourAllotment();
        $this->assertTrue($tourAllotment instanceof FlightTourAllotment);
        $this->assertEquals(null, $tourAllotment->getTourName());
        $this->assertEquals("HOLIDAY_TOUR", $tourAllotment->getTourReference());
        $this->assertEquals("FREE", $tourAllotment->getMode());
        $this->assertEquals(4, $tourAllotment->getRemainingSeats());

        // Co2Emission
        $co2Emissions = $segments[0]->getCo2Emissions();
        $this->assertTrue($co2Emissions[0] instanceof Co2Emission);
        $this->assertEquals(90, $co2Emissions[0]->getWeight());
        $this->assertEquals("KG", $co2Emissions[0]->getWeightUnit());
        $this->assertEquals("PREMIUM_ECONOMY", $co2Emissions[0]->getCabin());

        // Departure
        $departure = $segments[0]->getDeparture();
        $this->assertTrue($departure instanceof FlightEndpoint);
        $this->assertEquals("CDG", $departure->getIataCode());
        $this->assertEquals("2D", $departure->getTerminal());
        $this->assertEquals("2020-10-15T09:50:00", $departure->getAt());

        // Arrival
        $arrival = $segments[0]->getArrival();
        $this->assertTrue($arrival instanceof FlightEndpoint);
        $this->assertEquals("STN", $arrival->getIataCode());
        $this->assertEquals(null, $arrival->getTerminal());
        $this->assertEquals("2020-10-15T10:10:00", $arrival->getAt());

        // AircraftEquipment
        $aircraft = $segments[0]->getAircraft();
        $this->assertTrue($aircraft instanceof AircraftEquipment);
        $this->assertEquals("319", $aircraft->getCode());

        // OperatingFlight
        $operating = $segments[0]->getOperating();
        $this->assertTrue($operating instanceof OperatingFlight);
        $this->assertEquals("U2", $operating->getCarrierCode());

        // FlightStop
        $stops = $segments[0]->getStops();
        $this->assertTrue($stops[0] instanceof FlightStop);
        $this->assertEquals("JFK", $stops[0]->getIataCode());
        $this->assertEquals("PT2H10M", $stops[0]->getDuration());
        $this->assertEquals("2017-10-23T20:00:00", $stops[0]->getArrivalAt());
        $this->assertEquals("2017-10-23T20:00:00", $stops[0]->getDepartureAt());

        // __toString()
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]),
            $flightAvailabilities[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]),
            $segments[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'availabilityClasses'}[0]),
            $availabilityClasses[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'availabilityClasses'}[2]->{'tourAllotment'}),
            $tourAllotment->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'co2Emissions'}[0]),
            $co2Emissions[0]->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'departure'}),
            $departure->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'arrival'}),
            $arrival->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'aircraft'}),
            $aircraft->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'operating'}),
            $operating->__toString()
        );
        $this->assertEquals(
            PHPUnitUtil::toString($data[0]->{'segments'}[0]->{'stops'}[0]),
            $stops[0]->__toString()
        );
    }
}
