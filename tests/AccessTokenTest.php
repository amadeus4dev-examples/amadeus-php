<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Client\AccessToken;
use Amadeus\Configuration;
use Amadeus\Exceptions\ResponseException;
use Amadeus\HTTPClient;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\HTTPClient
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Client\AccessToken
 */
final class AccessTokenTest extends TestCase
{
    private HTTPClient $client;
    private object $result;

    /**
     * @Before
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        $configuration = new Configuration("client_id", "client_secret");

        $this->client = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($configuration))
            ->getMock();

        $this->client->expects($this->any())
            ->method("getConfiguration")
            ->willReturn($configuration);

        $this->result = (object) [
            "access_token" => "my_token",
            "expires_in" => 1799
        ];

        $accessToken = new AccessToken($this->client);
        PHPUnitUtil::callMethod($accessToken, "storeAccessToken", array($this->result));

        $this->client->expects($this->any())
            ->method("getAccessToken")
            ->willReturn($accessToken);
    }

    /**
     * @throws ResponseException
     */
    public function testParseAccessToken(): void
    {
        $accessToken = $this->client->getAccessToken();
        //$this->assertEquals(time()+1789, $accessToken->getExpiresAt());
        $this->assertEquals('my_token', $accessToken->getBearerToken());
    }

    /**
     * @throws ResponseException
     */
    public function testFetchAccessTokenWhenNotExpired(): void
    {
        $obj = $this->getMockBuilder(AccessToken::class)
            ->setConstructorArgs(array($this->client))
            ->onlyMethods(array("fetchAccessToken"))
            ->getMock();

        $obj->expects($this->exactly(1))
            ->method('fetchAccessToken')
            ->willReturn($this->result);

        $obj->getBearerToken();
        $obj->getBearerToken();
    }

    /**
     * @throws ResponseException
     */
    public function testUpdateAccessTokenWhenExpired(): void
    {
        $obj = $this->getMockBuilder(AccessToken::class)
            ->setConstructorArgs(array($this->client))
            ->onlyMethods(array("fetchAccessToken"))
            ->getMock();

        $this->result->expires_in = -1;

        $obj->expects($this->exactly(2))
            ->method('fetchAccessToken')
            ->willReturn($this->result);

        $obj->getBearerToken();
        $obj->getBearerToken();
    }
}
