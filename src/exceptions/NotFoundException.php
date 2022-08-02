<?php

declare(strict_types=1);

namespace Amadeus\Exceptions;

use Amadeus\Client\Response;

/**
 * Inherit __construct() from parent class
 *
 * HTTP status Code : 404
 * @see BasicHTTPClient::detectError()
 */
class NotFoundException extends ResponseException
{
}
