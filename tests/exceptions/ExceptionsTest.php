<?php

declare(strict_types=1);

namespace Amadeus\Tests\Exceptions;

use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NetworkException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;
use Amadeus\Client\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amadeus\Client\Response
 * @covers \Amadeus\Exceptions\ResponseException
 * @covers \Amadeus\Exceptions\AuthenticationException
 * @covers \Amadeus\Exceptions\ClientException
 * @covers \Amadeus\Exceptions\NotFoundException
 * @covers \Amadeus\Exceptions\ServerException
 * @covers \Amadeus\Exceptions\NetworkException
 */
final class ExceptionsTest extends TestCase
{
    private string $dateFormat = "F j, Y, g:i a";
    private string $exception = "Amadeus\Exceptions\ResponseException: ";
    private string $message = "Message: ";
    private string $url = "Url: ";

    public function testNoResponse(): void
    {
        $error = new ResponseException(null);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date($this->dateFormat).']'."\n"
            .$this->exception."[0]"."\n"
            .$this->message."\n"
            .$this->url."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testNoStatusCode(): void
    {
        $request = null;
        $info = array(
            "http_code" => null
        );
        $result = "message";
        $response = new Response($request, $info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date($this->dateFormat).']'."\n"
            .$this->exception."[0]"."\n"
            .$this->message."message"."\n"
            .$this->url."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testNoMessage(): void
    {
        $request = null;
        $info = array(
            "url" => null,
            "http_code" => 400,
            "header_size" => 0
        );
        $result = null;
        $response = new Response($request, $info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date($this->dateFormat).']'."\n"
            .$this->exception."[400]"."\n"
            .$this->message."\n"
            .$this->url."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testWithMessage(): void
    {
        $request = null;
        $info = array(
            "url" => null,
            "http_code" => 400,
            "header_size" => 0
        );
        $result = "message";
        $response = new Response($request, $info, $result);
        $error = new ResponseException($response);
        $error = explode("\n", $error->__toString());
        $this->assertEquals(
            '['.date($this->dateFormat).']'."\n"
            .$this->exception."[400]"."\n"
            .$this->message."message"."\n"
            .$this->url."\n",
            join("\n", array_slice($error, 0, 4))."\n"
        );
    }

    public function testOtherExceptions(): void
    {
        $this->assertTrue(new AuthenticationException(null) instanceof ResponseException);
        $this->assertTrue(new ClientException(null) instanceof ResponseException);
        $this->assertTrue(new NotFoundException(null) instanceof ResponseException);
        $this->assertTrue(new ServerException(null) instanceof ResponseException);
        $this->assertTrue(new NetworkException(null) instanceof ResponseException);
    }
}
