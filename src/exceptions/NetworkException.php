<?php

declare(strict_types=1);

namespace Amadeus\Exceptions;

use Amadeus\Client\Response;

class NetworkException extends ResponseException
{
    /**
     * @param Response|null $response
     */
    public function __construct(?Response $response)
    {
        parent::__construct($response);
    }
}
