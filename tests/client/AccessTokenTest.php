<?php

declare(strict_types=1);

namespace Amadeus\Tests\Client;

use Amadeus\Client\AccessToken;
use Amadeus\Configuration;
use Amadeus\Client\BasicHTTPClient;
use Amadeus\Tests\PHPUnitUtil;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Client\BasicHTTPClient
 */
final class AccessTokenTest extends TestCase
{
    private BasicHTTPClient $client;

    /**
     * @Before
     */
    protected function setUp(): void
    {
        $configuration = new Configuration("client_id", "client_secret");

        $this->client = $this->getMockBuilder(BasicHTTPClient::class)
            ->setConstructorArgs(array($configuration))
            ->getMock();

        $this->client->expects($this->any())
            ->method("getConfiguration")
            ->willReturn($configuration);

        $accessToken = new AccessToken($this->client, __DIR__."/cached_token_test.json");

        $this->client->expects($this->any())
            ->method("getAccessToken")
            ->willReturn($accessToken);
    }

    public function testParseAccessToken(): void
    {
        $accessToken = $this->client->getAccessToken();
        $this->assertEquals('my_token', $accessToken->getBearerToken());
        $this->assertEquals(999999999999, $accessToken->getExpiresAt());
    }

    public function testFetchAccessTokenWhenNotExpired(): void
    {
        $result = (object) [
            "access_token" => "my_token",
            "expires_in" => 1799
        ];

        $obj = $this->getMockBuilder(AccessToken::class)
            ->setConstructorArgs(array($this->client, __DIR__ . "/cached_token_null_test.json"))
            ->onlyMethods(array("fetchAccessToken"))
            ->getMock();

        $obj->expects($this->exactly(1))
            ->method('fetchAccessToken')
            ->willReturn($result);

        $obj->getBearerToken();
        $obj->getBearerToken();

        $obj->resetCachedToken();
    }

    public function testUpdateAccessTokenWhenExpired(): void
    {
        $result = (object) [
            "access_token" => "my_token",
            "expires_in" => -1
        ];

        $obj = $this->getMockBuilder(AccessToken::class)
            ->setConstructorArgs(array($this->client, __DIR__ . "/cached_token_null_test.json"))
            ->onlyMethods(array("fetchAccessToken"))
            ->getMock();

        $obj->expects($this->exactly(2))
            ->method('fetchAccessToken')
            ->willReturn($result);

        $obj->getBearerToken();
        $obj->getBearerToken();

        $obj->resetCachedToken();
    }
}
