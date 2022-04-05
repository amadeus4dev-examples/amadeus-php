<?php declare(strict_types=1);

namespace Amadeus\Exceptions;

use Amadeus\Response;
use Exception;

class ResponseException extends Exception
{
    private ?string $url = null;

    /**
     * @param Response|null $response
     */
    public function __construct(?Response $response)
    {
        if($response != null)
        {
            if($response->getUrl() != null)
            {
                $this->url = $response->getUrl();
            }

            if($response->getHeaders() != null
                && $response->getBody() != null
                && $response->getStatusCode() != null)
            {
                parent::__construct($response->getHeaders().$response->getBody(), $response->getStatusCode());
            }
        }
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return '['.date("F j, Y, g:i a").']'."\n"
            .get_class($this) .": [$this->code]" ."\n"
            ."Message: ".$this->message ."\n"
            ."Url: ".$this->getUrl() ."\n"
            ."Trace: ".$this->getTraceAsString()."\n";
    }
}