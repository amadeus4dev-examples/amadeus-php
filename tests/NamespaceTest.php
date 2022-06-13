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
 * @covers \Amadeus\Shopping
 * @covers \Amadeus\Shopping\Availability
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 * @covers \Amadeus\Shopping\FlightOffers
 * @covers \Amadeus\ReferenceData
 * @covers \Amadeus\ReferenceData\Locations
 */
final class NamespaceTest extends TestCase
{
    public function testAllNamespacesExist(): void
    {
        $amadeus = Amadeus::builder("id", "secret")->build();

        // Airport
        $this->assertNotNull($amadeus->getAirport());
        $this->assertNotNull($amadeus->getAirport()->getDirectDestinations());

        // Shopping
        $this->assertNotNull($amadeus->getShopping());
        $this->assertNotNull($amadeus->getShopping()->getAvailability());
        $this->assertNotNull($amadeus->getShopping()->getAvailability()->getFlightAvailabilities());
        $this->assertNotNull($amadeus->getShopping()->getFlightOffers());

        // ReferenceData
        $this->assertNotNull($amadeus->getReferenceData());
        $this->assertNotNull($amadeus->getReferenceData()->getLocations());
    }
}
