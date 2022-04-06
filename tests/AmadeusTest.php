<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Amadeus;
use Amadeus\Configuration;
use PHPUnit\Framework\TestCase;
use TypeError;

final class AmadeusTest extends TestCase
{
    /**
     * @return void
     */
    public function testBuilder(): void
    {
        $this->assertTrue(
            Amadeus::builder("id", "secret") instanceof Configuration,
            "should return a Configuration"
        );
    }

    /**
     * @return void
     */
    public function testBuilderWithNullClientId(): void
    {
        $this->expectException(TypeError::class);
        /* @phpstan-ignore-next-line */
        Amadeus::builder(null, "secret")->build();
    }

    /**
     * @return void
     */
    public function testBuilderWithNullClientSecret(): void
    {
        $this->expectException(TypeError::class);
        /* @phpstan-ignore-next-line */
        Amadeus::builder("id", null)->build();
    }
}
