<?php

declare(strict_types=1);

namespace Amadeus\Exceptions;

/**
 * Inherit __construct() from parent class
 *
 * HTTP status Code : 0
 * @see BasicHTTPClient::detectError()
 */
class NetworkException extends ResponseException
{
}
