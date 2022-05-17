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
            "type" => "amadeusOAuth2Token",
            "username" => "foo@bar.com",
            "application_name" => "foobar",
            "client_id" => $configuration->getClientId(),
            "token_type" => "Bearer",
            "access_token" => "my_token",
            "expires_in" => 1799,
            "state" => "approved",
            "scope" => " "
        ];

        $accessToken = new AccessToken($this->client);
        PHPUnitUtil::callMethod($accessToken, "constructToken", array($this->result));

        $this->client->expects($this->any())
            ->method("getAuthorizedToken")
            ->willReturn($accessToken);
    }

    /**
     * @throws ResponseException
     */
    public function testParseAccessToken(): void
    {
        $accessToken = $this->client->getAuthorizedToken();
        //$this->assertEquals(time()+1789, $accessToken->getExpiresAt());
        $this->assertEquals("amadeusOAuth2Token", $accessToken->getType());
        $this->assertEquals("foo@bar.com", $accessToken->getUsername());
        $this->assertEquals("foobar", $accessToken->getApplicationName());
        $this->assertEquals("client_id", $accessToken->getClientId());
        $this->assertEquals("Bearer", $accessToken->getTokenType());
        $this->assertEquals('my_token', $accessToken->getAccessToken());
        $this->assertEquals(1799, $accessToken->getExpiresIn());
        $this->assertEquals("approved", $accessToken->getState());
        $this->assertEquals(" ", $accessToken->getScope());
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

        $obj->getAccessToken();
        $obj->getAccessToken();
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

        $this->result->expires_at = 0;

        $obj->expects($this->exactly(2))
            ->method('fetchAccessToken')
            ->willReturn($this->result);

        $obj->getAccessToken();
        $obj->getAccessToken();
    }
}
