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
 * @covers \Amadeus\BasicHTTPClient
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Client\AccessToken
 */
final class AccessTokenTest extends TestCase
{
    private BasicHTTPClient $client;

    /**
     * @Before
     * @throws ReflectionException
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

        $result = (object) [
            "access_token" => "my_token",
            "expires_in" => 1799
        ];

        $accessToken = new AccessToken($this->client);
        PHPUnitUtil::callMethod($accessToken, "storeAccessToken", array($result));

        $this->client->expects($this->any())
            ->method("getAccessToken")
            ->willReturn($accessToken);
    }

    public function testParseAccessToken(): void
    {
        $accessToken = $this->client->getAccessToken();
        $this->assertEquals(1799, $accessToken->getExpiresIn());
        //$this->assertEquals(time()+1799, $accessToken->getExpiresAt());
        $this->assertEquals('my_token', $accessToken->getBearerToken());
    }

    public function testSetter(): void
    {
        $accessToken = $this->client->getAccessToken();
        //$accessToken->setExpiresAt(time()+1789);
        $accessToken->setBearerToken("new_token");
        //$this->assertEquals(time()+1789, $accessToken->getExpiresAt());
        $this->assertEquals('new_token', $accessToken->getBearerToken());
    }

//    public function testFetchAccessTokenWhenNotExpired(): void
//    {
//        $obj = $this->getMockBuilder(AccessToken::class)
//            ->setConstructorArgs(array($this->client))
//            ->onlyMethods(array("fetchAccessToken"))
//            ->getMock();
//
//        $obj->expects($this->exactly(1))
//            ->method('fetchAccessToken')
//            ->willReturn($this->result);
//
//        $obj->getBearerToken();
//        $obj->getBearerToken();
//    }
//
//    public function testUpdateAccessTokenWhenExpired(): void
//    {
//        $obj = $this->getMockBuilder(AccessToken::class)
//            ->setConstructorArgs(array($this->client))
//            ->onlyMethods(array("fetchAccessToken"))
//            ->getMock();
//
//        $this->result->expires_in = -1;
//
//        $obj->expects($this->exactly(2))
//            ->method('fetchAccessToken')
//            ->willReturn($this->result);
//
//        $obj->getBearerToken();
//        $obj->getBearerToken();
//    }
}
