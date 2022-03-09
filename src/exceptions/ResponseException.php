<?php declare(strict_types=1);

namespace Amadeus\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseException extends Exception
{
    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response->getBody()->__toString(),$response->getStatusCode(),null);
    }

    public function __toString(): string
    {
        return get_class($this) . ": [{$this->code}] {$this->message}\n";
    }
}