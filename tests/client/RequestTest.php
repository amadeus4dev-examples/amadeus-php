<?php

declare(strict_types=1);

namespace Amadeus\Tests\Client;

use Amadeus\Amadeus;
use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;
use Amadeus\Client\Request;
use Amadeus\Configuration;
use Amadeus\Constants;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Client\BasicHTTPClient
 * @covers \Amadeus\Client\AccessToken
 * @covers \Amadeus\Client\Request
 */
final class RequestTest extends TestCase
{
    private HTTPClient $client;

    /**
     * @Before
     */
    public function setUp(): void
    {
        $this->client = new BasicHTTPClient(new Configuration("id", "secret"));
    }

    public function testInitializer(): void
    {
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            "token",
            $this->client
        );

        $this->assertEquals("GET", $request->getVerb());
        $this->assertEquals("test.api.amadeus.com", $request->getHost());
        $this->assertEquals("/foo/bar", $request->getPath());
        $this->assertEquals($params, $request->getParams());
        $this->assertNull($request->getBody());
        $this->assertEquals("token", $request->getBearerToken());
        $this->assertEquals(Amadeus::VERSION, $request->getClientVersion());
        $this->assertEquals(phpversion(), $request->getLanguageVersion());
        $this->assertEquals(443, $request->getPort());
        $this->assertTrue($request->isSsl());
        $this->assertEquals("https", $request->getScheme());
        $this->assertEquals(3, sizeof($request->getHeaders()));
        $this->assertTrue(in_array(
            "Accept: application/json, application/vnd.amadeus+json",
            $request->getHeaders()
        ));
        $this->assertTrue(in_array(
            "Content-Type: application/vnd.amadeus+json",
            $request->getHeaders()
        ));
        $this->assertTrue(in_array(
            "Authorization: Bearer token",
            $request->getHeaders()
        ));
    }

    public function testInitializerWithoutBearerToken(): void
    {
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $this->client
        );

        $this->assertEquals(1, sizeof($request->getHeaders()));
    }

    public function testInitializerWithHTTP(): void
    {
        $client = new BasicHTTPClient((new Configuration("id", "secret"))->setSsl(false));
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            null,
            $client
        );

        $this->assertEquals("http", $request->getScheme());
    }

    public function testBuildUriForGetRequest(): void
    {
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            "token",
            $this->client
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar?foo=bar", $request->getUri());
    }

    public function testBuildUriForGetRequestWithoutParams(): void
    {
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            null,
            $this->client
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar", $request->getUri());
    }

    public function testBuildUriForPostRequest(): void
    {
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            "token",
            $this->client
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar?foo=bar", $request->getUri());
    }

    public function testRequestWithoutHttpOverrideHeader(): void
    {
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            "token",
            $this->client
        );

        $this->assertFalse(in_array("X-HTTP-Method-Override: GET", $request->getHeaders()));
    }

    public function testRequestWithHttpOverrideHeader(): void
    {
        foreach (Constants::API_NEED_EXTRA_HEADER as $path) {
            $request = new Request(
                "POST",
                $path,
                null,
                null,
                "token",
                $this->client
            );

            $this->assertTrue(in_array("X-HTTP-Method-Override: GET", $request->getHeaders()));
        }
    }

    public function testBuildRequestWithSslCert(): void
    {
        $this->client->setSslCertificate("./cert.pem");
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $this->client
        );

        $this->assertEquals("./cert.pem", $request->getSslCertificate());
    }
}
