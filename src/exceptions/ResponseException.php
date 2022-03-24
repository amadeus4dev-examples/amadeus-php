<?php declare(strict_types=1);

namespace Amadeus\Exceptions;

use Amadeus\Response;
use Exception;

class ResponseException extends Exception
{
    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct(json_encode($response->getResult()),$response->getInfo()->{'http_code'});
    }

    public function __toString(): string
    {
        return get_class($this) . ": [$this->code] $this->message\n";
    }
}