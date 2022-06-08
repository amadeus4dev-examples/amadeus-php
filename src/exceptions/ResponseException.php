<?php

declare(strict_types=1);

namespace Amadeus\Exceptions;

use Amadeus\Client\Response;
use Exception;

class ResponseException extends Exception
{
    private ?string $url = null;

    /**
     * @param Response|null $response
     */
    public function __construct(?Response $response)
    {
        if ($response != null) {
            if ($response->getUrl() != null) {
                $this->url = $response->getUrl();
            }

            if (($response->getResult() != null) && ($response->getStatusCode() != null)) {
                parent::__construct($response->getResult(), $response->getStatusCode());
            } elseif ($response->getResult() != null) {
                parent::__construct($response->getResult());
            } elseif ($response->getStatusCode() != null) {
                parent::__construct("", $response->getStatusCode());
            } else {
                parent::__construct();
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
