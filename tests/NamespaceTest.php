<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Amadeus;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\AmadeusBuilder
 * @covers \Amadeus\Client\BasicHTTPClient
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Resources\Resource
 * @covers \Amadeus\Airport
 * @covers \Amadeus\Airport\DirectDestinations
 * @covers \Amadeus\Booking
 * @covers \Amadeus\Booking\FlightOrders
 * @covers \Amadeus\Booking\HotelBookings
 * @covers \Amadeus\DutyOfCare
 * @covers \Amadeus\DutyOfCare\Diseases
 * @covers \Amadeus\DutyOfCare\Diseases\Covid19AreaReport
 * @covers \Amadeus\ReferenceData
 * @covers \Amadeus\ReferenceData\Airlines
 * @covers \Amadeus\ReferenceData\Locations
 * @covers \Amadeus\ReferenceData\Locations\Airports
 * @covers \Amadeus\ReferenceData\Locations\Hotel
 * @covers \Amadeus\ReferenceData\Locations\Hotels
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByCity
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByGeocode
 * @covers \Amadeus\ReferenceData\Locations\Hotels\ByHotels
 * @covers \Amadeus\Schedule
 * @covers \Amadeus\Schedule\Flights
 * @covers \Amadeus\Shopping
 * @covers \Amadeus\Shopping\Availability
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 * @covers \Amadeus\Shopping\FlightDates
 * @covers \Amadeus\Shopping\FlightOffers
 * @covers \Amadeus\Shopping\FlightOffers\Pricing
 * @covers \Amadeus\Shopping\HotelOffer
 * @covers \Amadeus\Shopping\HotelOffers
 * @covers \Amadeus\Travel
 * @covers \Amadeus\Travel\Predictions
 * @covers \Amadeus\Travel\Predictions\FlightDelay
 */
final class NamespaceTest extends TestCase
{
    public function testAllNamespacesExist(): void
    {
        $amadeus = Amadeus::builder("id", "secret")->build();

        // Configuration
        $this->assertNotNull($amadeus->getConfiguration());

        // Configuration
        $this->assertNotNull($amadeus->getClient());

        // Airport
        $this->assertNotNull($amadeus->getAirport());
        $this->assertNotNull($amadeus->getAirport()->getDirectDestinations());

        // Booking
        $this->assertNotNull($amadeus->getBooking());
        $this->assertNotNull($amadeus->getBooking()->getFlightOrders());
        $this->assertNotNull($amadeus->getBooking()->getHotelBookings());

        // Shopping
        $this->assertNotNull($amadeus->getShopping());
        $this->assertNotNull($amadeus->getShopping()->getAvailability());
        $this->assertNotNull($amadeus->getShopping()->getAvailability()->getFlightAvailabilities());
        $this->assertNotNull($amadeus->getShopping()->getFlightOffers());
        $this->assertNotNull($amadeus->getShopping()->getFlightOffers()->getPricing());
        $this->assertNotNull($amadeus->getShopping()->getHotelOffer());
        $this->assertNotNull($amadeus->getShopping()->getHotelOffers());
        $this->assertNotNull($amadeus->getShopping()->getFlightDates());

        // ReferenceData
        $this->assertNotNull($amadeus->getReferenceData());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getHotel());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getHotels());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getHotels()->getByCity());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getHotels()->getByGeocode());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getHotels()->getByHotels());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations()->getAirports());
        $this->assertNotNull($amadeus->getReferenceData()->getAirlines());

        // Schedule
        $this->assertNotNull($amadeus->getSchedule());
        $this->assertNotNull($amadeus->getSchedule()->getFlights());

        // Travel
        $this->assertNotNull($amadeus->getTravel());
        $this->assertNotNull($amadeus->getTravel()->getPredictions());
        $this->assertNotNull($amadeus->getTravel()->getPredictions()->getFlightDelay());

        // DutyOfCare
        $this->assertNotNull($amadeus->getDutyOfCare());
        $this->assertNotNull($amadeus->getDutyOfCare()->getDiseases());
        $this->assertNotNull($amadeus->getDutyOfCare()->getDiseases()->getCovid19AreaReport());
    }
}
