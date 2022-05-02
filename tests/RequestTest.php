<?php

declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Amadeus;
use Amadeus\Constants;
use Amadeus\Request;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Configuration
 * @covers \Amadeus\Amadeus
 * @covers \Amadeus\HTTPClient
 * @covers \Amadeus\Request
 * @covers \Amadeus\Airport
 * @covers \Amadeus\Airport\DirectDestinations
 * @covers \Amadeus\Shopping
 * @covers \Amadeus\Shopping\Availability
 * @covers \Amadeus\Shopping\Availability\FlightAvailabilities
 * @covers \Amadeus\Shopping\FlightOffers
 */
final class RequestTest extends TestCase
{
    public function testInitializer(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            "token",
            $amadeus
        );

        $this->assertEquals("GET", $request->getVerb());
        $this->assertEquals("test.api.amadeus.com", $request->getHost());
        $this->assertEquals("/foo/bar", $request->getPath());
        $this->assertEquals($params, $request->getParams());
        $this->assertNull($request->getBody());
        $this->assertEquals("token", $request->getBearerToken());
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
        $amadeus = Amadeus::builder("123", " 234")->build();
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $amadeus
        );

        $this->assertEquals(1, sizeof($request->getHeaders()));
    }

    public function testInitializerWithHTTP(): void
    {
        $amadeus = Amadeus::builder("123", " 234")
            ->setSsl(false)
            ->build();
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            null,
            $amadeus
        );

        $this->assertEquals("http", $request->getScheme());
    }

    public function testBuildUriForGetRequest(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $amadeus
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar?foo=bar", $request->getUri());
    }

    public function testBuildUriForGetRequestWithoutParams(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            null,
            $amadeus
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar?", $request->getUri());
    }

    public function testBuildUriForPostRequest(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $amadeus
        );

        $this->assertEquals("https://test.api.amadeus.com:443/foo/bar?foo=bar", $request->getUri());
    }

    public function testRequestWithoutHttpOverrideHeader(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $request = new Request(
            "GET",
            "/foo/bar",
            null,
            null,
            "token",
            $amadeus
        );

        $this->assertFalse(in_array("X-HTTP-Method-Override: GET", $request->getHeaders()));
    }

    public function testRequestWithHttpOverrideHeader(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        foreach (Constants::API_NEED_EXTRA_HEADER as $path) {
            $request = new Request(
                "POST",
                $path,
                null,
                null,
                "token",
                $amadeus
            );

            $this->assertTrue(in_array("X-HTTP-Method-Override: GET", $request->getHeaders()));
        }
    }

    public function testBuildRequestWithSslCert(): void
    {
        $amadeus = Amadeus::builder("123", " 234")->build();
        $amadeus->setSslCertificate("./cert.pem");
        $params = array("foo" => "bar");
        $request = new Request(
            "GET",
            "/foo/bar",
            $params,
            null,
            null,
            $amadeus
        );

        $this->assertEquals("./cert.pem", $request->getSslCertificate());
    }
}
