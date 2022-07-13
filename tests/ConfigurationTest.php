<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Configuration
 */
final class ConfigurationTest extends TestCase
{
    public function testInitialize(): void
    {
        $this->assertTrue(
            (new Configuration("id", "secret")) instanceof Configuration,
            "should return a Configuration instance"
        );
    }

    public function testGetClientIdAndSecret(): void
    {
        $configuration = new Configuration("123", "234");
        $this->assertEquals("123", $configuration->getClientId());
        $this->assertEquals("234", $configuration->getClientSecret());
    }

    public function testBuildDefault(): void
    {
        $configuration = new Configuration("id", "secret");
        $this->assertEquals("test.api.amadeus.com", $configuration->getHost());
        $this->assertTrue($configuration->isSsl());
        $this->assertEquals(443, $configuration->getPort());
    }

    public function testSetSslAndPort(): void
    {
        $configuration = (new Configuration("id", "secret"))->setSsl(false);
        $this->assertFalse($configuration->isSsl());
        $this->assertEquals(80, $configuration->getPort());
    }

    public function testBuildWithProductionEnvironment(): void
    {
        $configuration = (new Configuration("id", "secret"))->setProductionEnvironment();
        $this->assertEquals("api.amadeus.com", $configuration->getHost());
    }

    public function testSetTimeout(): void
    {
        $configuration = (new Configuration("id", "secret"))->setTimeout(20);
        $this->assertEquals(20, $configuration->getTimeout());
    }
}
