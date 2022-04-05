<?php declare(strict_types=1);

namespace Amadeus;

class Response
{
    private ?string $url = null;
    private ?int $statusCode = null;

    private ?string $headers = null;
    private ?string $body = null;

    /**
     * @param array|null $info
     * @param string|null $headers
     * @param string|null $body
     */
    public function __construct(?array $info, ?string $headers, ?string $body)
    {
        if($info != null)
        {
            if(array_key_exists('url', $info)) $this->url = $info['url'];
            if(array_key_exists('http_code', $info)) $this->statusCode = $info['http_code'];
        }

        if($headers != null)
        {
            $this->headers = $headers;
        }

        if($body != null)
        {
            $this->body = $body;
        }
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @return string|null
     */
    public function getHeaders(): ?string
    {
        return $this->headers;
    }

    /**
     * @return array|null
     */
    public function getHeadersAsArray(): ?array
    {
        return $this->headersToArray($this->headers);
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return object
     */
    public function getBodyAsJsonObject(): ?object
    {
        return json_decode($this->body);
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->getBodyAsJsonObject()->{'data'};
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }

    /**
     * Convert the output header to array
     * @param string $str
     * @return array
     */
    public function headersToArray(string $str): array
    {
        $headers = array();
        $headersTmpArray = explode( "\r\n" , $str );
        for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
        {
            // we don't care about the two \r\n lines at the end of the headers
            if ( strlen( $headersTmpArray[$i] ) > 0 )
            {
                // the headers start with HTTP status codes, which do not contain a colon, so we can filter them out too
                if ( strpos( $headersTmpArray[$i] , ":" ) )
                {
                    $headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
                    $headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" ) + 1 );
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }
}