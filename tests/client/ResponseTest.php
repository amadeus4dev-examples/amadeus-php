<?php

declare(strict_types=1);

namespace Amadeus\Tests\Client;

use Amadeus\Client\Request;
use Amadeus\Client\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Client\Response
 */
final class ResponseTest extends TestCase
{
    private Request $request;
    private Response $response;
    private string $responseHeaders;
    private string $responseBody;
    private string $responseResult;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $info = array(
            "url" => "/foo/bar",
            "http_code" => 200,
            "header_size" => 8
        );
        $this->responseHeaders = "foo: bar";
        $this->responseBody = " "
            ."{"
            ."\"data\" : [ {"
            ." \"foo\" : \"bar\""
            ." } ]"
            ."}";
        $this->responseResult = $this->responseHeaders . $this->responseBody;
        $this->request = $this->createMock(Request::class);
        $this->response = new Response($this->request, $info, $this->responseResult);
    }

    public function testInitialize(): void
    {
        $this->assertEquals($this->request, $this->response->getRequest());
    }

    public function testParse(): void
    {
        $this->assertNotNull($this->response->getInfo());
        $this->assertEquals("/foo/bar", $this->response->getUrl());
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals(8, $this->response->getHeaderSize());

        $this->assertNotNull($this->response->getResult());
        $this->assertEquals(
            $this->responseHeaders,
            $this->response->getHeaders()
        );
        $this->assertEquals(
            $this->responseBody,
            $this->response->getBody()
        );
    }

    public function testParseBodyData(): void
    {
        $data[] = (object) ['foo' => 'bar'];
        $this->assertEquals($data, $this->response->getData());
    }

    public function testGetHeadersAsArray(): void
    {
        $headers['foo'] = 'bar';
        $this->assertEquals($headers, $this->response->getHeadersAsArray());
    }

    public function testToString(): void
    {
        $this->assertEquals($this->responseResult, $this->response->__toString());
    }
}
