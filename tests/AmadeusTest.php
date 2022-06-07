<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Amadeus;
use Amadeus\Configuration;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\Configuration
 */
final class AmadeusTest extends TestCase
{
    public function testBuilder(): void
    {
        $this->assertTrue(
            Amadeus::builder("id", "secret") instanceof Configuration,
            "should return a Configuration instance"
        );
    }

    public function testBuilderWithNullClientId(): void
    {
        $this->expectException(TypeError::class);
        Amadeus::builder(null, "secret")->build();
    }

    public function testBuilderWithNullClientSecret(): void
    {
        $this->expectException(TypeError::class);
        Amadeus::builder("id", null)->build();
    }
}
