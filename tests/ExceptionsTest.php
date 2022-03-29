<?php declare(strict_types=1);

namespace Amadeus\Tests;

use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;
use Amadeus\Response;
use PHPUnit\Framework\TestCase;

final class ExceptionsTest extends TestCase
{
    public function testNoResponse()
    {
        $error = new ResponseException(null);
        print($error);
        $this->assertEquals(
            "Amadeus\Exceptions\ResponseException: [0]",
            $error->__toString()
        );
    }

    public function testNoStatusCode()
    {
        $info = array(
            "http_code" => null
        );
        $result = (object) null;
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        print($error);
        $this->assertEquals(
            "Amadeus\Exceptions\ResponseException: [0]",
            $error->__toString()
        );
    }

    public function testNoMessage()
    {
        $info = array(
            "url" => null,
            "http_code" => 400
        );
        $result = (object) null;
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        print($error);
        $this->assertEquals(
            "Amadeus\Exceptions\ResponseException: [400]{}",
            $error->__toString()
        );
    }

    public function testWithMessage()
    {
        $info = array(
            "url" => null,
            "http_code" => 401
        );
        $result = (object)[
            "error_description" => "error message"
        ];
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        print($error);
        $this->assertEquals(
            "Amadeus\Exceptions\ResponseException: [401]{\"error_description\":\"error message\"}",
            $error->__toString()
        );
    }

    public function testOtherExceptions()
    {
        $this->assertTrue(new AuthenticationException(null) instanceof ResponseException);
        $this->assertTrue(new ClientException(null) instanceof ResponseException);
        $this->assertTrue(new NotFoundException(null) instanceof ResponseException);
        $this->assertTrue(new ServerException(null) instanceof ResponseException);
    }
}