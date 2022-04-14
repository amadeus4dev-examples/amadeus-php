<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Client\AccessToken;
use Amadeus\Configuration;
use Amadeus\Exceptions\ResponseException;
use Amadeus\HTTPClient;
use Amadeus\Request;
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
    private Configuration $configuration;
    private object $result;

    /**
     * @Before
     */
    protected function setUp(): void
    {
        $this->configuration = new Configuration("client_id", "client_secret");

        $this->client = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->getMock();

        $this->client->expects($this->any())
            ->method("getConfiguration")
            ->willReturn($this->configuration);

        $this->result = (object) [
            "type" => "amadeusOAuth2Token",
            "username" => "foo@bar.com",
            "application_name" => "foobar",
            "client_id" => $this->configuration->getClientId(),
            "token_type" => "Bearer",
            "access_token" => "my_token",
            "expires_in" => 1799,
            "state" => "approved",
            "scope" => " "
        ];
        $this->client->expects($this->any())
            ->method("getAuthorizedToken")
            ->willReturn(new AccessToken($this->result));
    }

    /**
     * @throws ResponseException
     */
    public function testParseAccessToken(): void
    {
        $accessToken = $this->client->getAuthorizedToken();
        $this->assertEquals(time()+1789, $accessToken->getExpiresAt());
        $this->assertEquals("amadeusOAuth2Token", $accessToken->getType());
        $this->assertEquals("foo@bar.com", $accessToken->getUsername());
        $this->assertEquals("foobar", $accessToken->getApplicationName());
        $this->assertEquals("client_id", $accessToken->getClientId());
        $this->assertEquals("Bearer", $accessToken->getTokenType());
        $this->assertEquals('my_token', $accessToken->getAccessToken());
        $this->assertEquals(1799, $accessToken->getExpiresIn());
        $this->assertEquals("approved", $accessToken->getState());
        $this->assertEquals(" ", $accessToken->getScope());
        $this->result->expires_at = $accessToken->getExpiresAt();
        $this->assertEquals(json_encode($this->result), $accessToken->__toString());
    }

    /**
     * @throws ResponseException
     */
    public function testFetchAccessTokenWhenNotExpired(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(array('fetchAccessToken'))
            ->getMock();
        $obj->expects($this->once())
            ->method('fetchAccessToken')
            ->willReturn(new AccessToken($this->result));
        $obj->getAuthorizedToken();
        $obj->getAuthorizedToken();
    }

    /**
     * @throws ResponseException
     */
    public function testUpdateAccessTokenWhenExpired(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(array('fetchAccessToken'))
            ->getMock();
        $this->result->expires_at = 0;
        $obj->expects($this->exactly(2))
            ->method('fetchAccessToken')
            ->willReturn(new AccessToken($this->result));
        $obj->getAuthorizedToken();
        $obj->getAuthorizedToken();
    }
}
