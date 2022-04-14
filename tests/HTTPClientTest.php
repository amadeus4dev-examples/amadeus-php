<?php

declare(strict_types=1);

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

        $obj->getWithArrayParams("/foo", $this->params);
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

        $obj->postWithStringBody("/foo", $this->body);
    }

    /**
     * @throws ReflectionException
     */
    public function testPost4FetchAccessToken(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('execute'))
            ->getMock();

        $params = array(
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $request = new Request(
            "POST",
            '/v1/security/oauth2/token',
            $params,
            null,
            null,
            $obj
        );

        $info = array(
            "url" => '/v1/security/oauth2/token',
            "http_code" => 200,
            "header_size" => 8
        );
        $result =
            "foo: bar"
            ." "
            ."{"
            ."\"data\" : [ {"
            ." \"access_token\" : \"my_token\""
            ." } ]"
            ."}"
        ;

        $obj->expects($this->once())
            ->method('execute')
            ->with($request)
            ->willReturn(new Response($request, $info, $result));

        PHPUnitUtil::callMethod($obj, 'fetchAccessToken', array());
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

    /**
     * @throws ReflectionException
     */
    public function testDetectNoException(): void
    {
        $response = $this->createMock(Response::class);
        $response->expects($this->any())
            ->method("getStatusCode")
            ->willReturn(204);
        $this->assertNull(PHPUnitUtil::callMethod($this->client, 'detectError', array($response)));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetCurlOptionsWithDefault(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('setCurlOptions'))
            ->getMock();

        $request = $this->getMockBuilder(Request::class)
            ->setConstructorArgs(array("GET", $this->path, null, null, null, $obj))
            ->getMock();

        $request->expects($this->once())->method('getUri');
        $request->expects($this->once())->method('getHeaders');

        PHPUnitUtil::callMethod($obj, "setCurlOptions", array(curl_init(), $request));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetCurlOptionsWithSsl(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('setCurlOptions'))
            ->getMock();

        $request = $this->getMockBuilder(Request::class)
            ->setConstructorArgs(array("GET", $this->path, null, null, 'my_token', $obj))
            ->getMock();

        $request->expects($this->any())
            ->method('getSslCertificate')
            ->willReturn('/foo');

        $request->expects($this->exactly(2))->method('getSslCertificate');

        PHPUnitUtil::callMethod($obj, "setCurlOptions", array(curl_init(), $request));
    }

    /**
     * @throws ReflectionException
     */
    public function testSetCurlOptionsWithPost(): void
    {
        $obj = $this->getMockBuilder(HTTPClient::class)
            ->setConstructorArgs(array($this->configuration))
            ->onlyMethods(array('setCurlOptions'))
            ->getMock();

        $request = $this->getMockBuilder(Request::class)
            ->setConstructorArgs(array("POST", $this->path, array("foo" => "bar"), "foo: bar", 'my_token', $obj))
            ->getMock();

        $request->expects($this->any())->method('getVerb')->willReturn("POST");
        $request->expects($this->any())->method('getParams')->willReturn(array("foo" => "bar"));
        $request->expects($this->any())->method('getBody')->willReturn("foo: bar");

        $request->expects($this->once())->method('getVerb');
        $request->expects($this->exactly(2))->method('getBody');
        $request->expects($this->exactly(2))->method('getParams');

        PHPUnitUtil::callMethod($obj, "setCurlOptions", array(curl_init(), $request));
    }
}
