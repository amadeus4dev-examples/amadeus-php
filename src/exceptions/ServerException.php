<?php

declare(strict_types=1);

namespace Amadeus\Exceptions;


/**
 * Inherit __construct() from parent class
 *
 * HTTP status Code : >= 500
 * @see BasicHTTPClient::detectError()
 */
class ServerException extends ResponseException
{
}
