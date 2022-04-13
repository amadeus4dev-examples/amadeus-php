<?php declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Client\AccessToken;
use Amadeus\Configuration;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;
use Amadeus\HTTPClient;
use Amadeus\Request;
use Amadeus\Response;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * @covers \Amadeus\HTTPClient
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Request
 * @covers \Amadeus\Response
 * @covers \Amadeus\Exceptions\ResponseException
 * @covers \Amadeus\Exceptions\ServerException
 * @covers \Amadeus\Exceptions\NotFoundException
 * @covers \Amadeus\Exceptions\AuthenticationException
 * @covers \Amadeus\Exceptions\ClientException
 */
final class HTTPClientTest extends TestCase
{
    private HTTPClient $client;
    private Configuration $configuration;
    private string $path;
    private array $params;
    private string $body;
    private AccessToken $accessToken;

    /**
     * @Before
     */
    protected function setUp(): void
    {
        $this->path = "/foo";
        $this->params = array("foo" => "bar");
        $this->body = "[{}]";

        $this->configuration = new Configuration("client_id", "client_secret");

        $this->client = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->getMock();

        $result = (object) [
            "access_token" => "my_token",
        ];
        $this->client->expects($this->any())
            ->method("getAuthorizedToken")
            ->willReturn(new AccessToken($result));

        $this->accessToken = new AccessToken($result);
    }

    /**
     * @throws ResponseException
     */
    public function testGetWithParams(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('execute', 'getAuthorizedToken'))
            ->getMock();
        $obj->expects($this->any())
            ->method("getAuthorizedToken")
            ->willReturn($this->accessToken);

        $request = new Request(
            "GET",
            $this->path,
            $this->params,
            null,
            $obj->getAuthorizedToken()->getAccessToken(),
            $obj
        );

        $obj->expects($this->once())
            ->method('execute')
            ->with($request);

        $obj->get("/foo", $this->params);
    }

    /**
     * @throws ResponseException
     */
    public function testPostWithBody(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('execute', 'getAuthorizedToken'))
            ->getMock();
        $obj->expects($this->any())
            ->method("getAuthorizedToken")
            ->willReturn($this->accessToken);

        $request = new Request(
            "POST",
            $this->path,
            null,
            $this->body,
            $obj->getAuthorizedToken()->getAccessToken(),
            $obj
        );

        $obj->expects($this->once())
            ->method('execute')
            ->with($request);

        $obj->post("/foo", $this->body);
    }

    /**
     * @throws ReflectionException
     */
    public function testDetectServerException(): void
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getStatusCode")
            ->willReturn(500);
        $this->expectException(ServerException::class);
        PHPUnitUtil::callMethod($this->client, 'detectError', array($response));
    }

    /**
     * @throws ReflectionException
     */
    public function testDetectNotFoundException(): void
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getStatusCode")
            ->willReturn(404);
        $this->expectException(NotFoundException::class);
        PHPUnitUtil::callMethod($this->client, 'detectError', array($response));
    }

    /**
     * @throws ReflectionException
     */
    public function testDetectAuthenticationException(): void
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getStatusCode")
            ->willReturn(401);
        $this->expectException(AuthenticationException::class);
        PHPUnitUtil::callMethod($this->client, 'detectError', array($response));
    }

    /**
     * @throws ReflectionException
     */
    public function testDetectClientException(): void
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getStatusCode")
            ->willReturn(400);
        $this->expectException(ClientException::class);
        PHPUnitUtil::callMethod($this->client, 'detectError', array($response));
    }

}
