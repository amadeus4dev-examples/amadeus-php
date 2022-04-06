<?php declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Configuration;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    public function testInitialize()
    {
        $this->assertTrue(
            (new Configuration("id", "secret")) instanceof Configuration,
            "should return a Configuration instance"
        );
    }

    public function testBuild()
    {
        $configuration = new Configuration("123", "234");
        $this->assertNotNull(
            $configuration->build(),
            "should return a Amadeus object"
        );
        $this->assertEquals(
            "123",
            $configuration->getClientId(),
            "should set the com.amadeus.client ID"
        );
        $this->assertEquals(
            "234",
            $configuration->getClientSecret(),
            "should set the com.amadeus.client secret"
        );
    }

    public function testBuildDefault()
    {
        $configuration = new Configuration("id", "secret");
        $this->assertEquals(
            "test.api.amadeus.com",
            $configuration->getHost()
        );
    }

    public function testBuildWithProductionEnvironment()
    {
        $configuration = (new Configuration("id", "secret"))
            ->setProductionEnvironment();
        $this->assertEquals(
          "api.amadeus.com",
          $configuration->getHost()
        );
    }

    public function testBuildWithLoggerSystemPath()
    {
        $configuration = (new Configuration("id", "secret"))
            ->setLogger();
        $this->assertEquals(
            true,
            $configuration->getLogger()
        );
        $this->assertEquals(
            0,
            $configuration->getMsgType()
        );
    }

    public function testBuildWithLoggerCustomPath()
    {
        $configuration = (new Configuration("id", "secret"))
            ->setLogger("./custom_path/amadeus.log");
        $this->assertEquals(
            true,
            $configuration->getLogger()
        );
        $this->assertEquals(
            "./custom_path/amadeus.log",
            $configuration->getMsgDestination()
        );
    }
}