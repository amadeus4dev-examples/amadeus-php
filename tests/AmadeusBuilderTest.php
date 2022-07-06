<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\AmadeusBuilder;
use Amadeus\Client\BasicHTTPClient;
use Amadeus\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\AmadeusBuilder
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Client\BasicHTTPClient
 * @covers \Amadeus\Configuration
 */
final class AmadeusBuilderTest extends TestCase
{
    private AmadeusBuilder $amadeusBuilder;
    private BasicHTTPClient $httpClient;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $configuration = new Configuration('id', 'secret');
        $this->httpClient = new BasicHTTPClient($configuration);
        $this->amadeusBuilder = new AmadeusBuilder($configuration);

        $this->amadeusBuilder
            ->setSsl(true)
            ->setPort(8080)
            ->setHost('localhost')
            ->setHttpClient($this->httpClient)
            ->setTimeout(20);
    }

    public function testInitialize(): void
    {
        $configuration = $this->amadeusBuilder->getConfiguration();
        $this->assertTrue($configuration->isSsl());
        $this->assertEquals(8080, $configuration->getPort());
        $this->assertEquals('localhost', $configuration->getHost());
        $this->assertEquals($this->httpClient, $this->amadeusBuilder->getConfiguration()->getHttpClient());
        $this->assertEquals(20, $this->amadeusBuilder->getConfiguration()->getTimeout());
    }

    public function testBuildWithProductionEnvironment(): void
    {
        $this->amadeusBuilder->setProductionEnvironment();
        $configuration = $this->amadeusBuilder->getConfiguration();
        $this->assertEquals('api.amadeus.com', $configuration->getHost());
    }
}
