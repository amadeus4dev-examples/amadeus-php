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
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date("F j, Y, g:i a").']'."\n"
            ."Amadeus\Exceptions\ResponseException: [0]"."\n"
            ."Message: "."\n"
            ."Url: "."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testNoStatusCode()
    {
        $info = array(
            "http_code" => null
        );
        $result = null;
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date("F j, Y, g:i a").']'."\n"
            ."Amadeus\Exceptions\ResponseException: [0]"."\n"
            ."Message: "."\n"
            ."Url: "."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testNoMessage()
    {
        $info = array(
            "url" => null,
            "http_code" => 400,
            "header_size" => 0
        );
        $result = null;
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date("F j, Y, g:i a").']'."\n"
            ."Amadeus\Exceptions\ResponseException: [400]"."\n"
            ."Message: "."\n"
            ."Url: "."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testWithMessage()
    {
        $info = array(
            "url" => null,
            "http_code" => 401,
            "header_size" => 0
        );
        $result = "message";
        $response = new Response($info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date("F j, Y, g:i a").']'."\n"
            ."Amadeus\Exceptions\ResponseException: [401]"."\n"
            ."Message: message"."\n"
            ."Url: "."\n",
            join("\n", array_slice($error, 0, 4))."\n"
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