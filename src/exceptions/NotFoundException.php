<?php declare(strict_types=1);

namespace Amadeus\Exceptions;

use Psr\Http\Message\ResponseInterface;

class NotFoundException extends ResponseException
{
    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }
}