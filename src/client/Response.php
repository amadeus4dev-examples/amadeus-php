<?php

declare(strict_types=1);

namespace Amadeus\Client;

/**
 * A generic response as received from an API call. Contains the status code, body,
 * and parsed JSON (if any).
 */
class Response
{
    /**
     * The information for the response, if any.
     */
    private ?array $info = null;

    /**
     * The raw result for the response, if any.
     */
    private ?string $result = null;

    /**
     * The url of calling this API.
     */
    private ?string $url = null;

    /**
     * The HTTP status code for the response, if any.
     */
    private ?int $statusCode = null;

    /**
     * The header size for the response, if any.
     */
    private ?int $headerSize = null;

    /**
     * The headers for the response, if any.
     */
    private ?string $headers = null;

    /**
     * The raw body received from the API.
     */
    private ?string $body = null;

    private ?Request $request = null;

    /**
     * Constructing a Response
     * @param Request|null $request
     * @param array|null $info
     * @param string|null $result
     */
    public function __construct(?Request $request, ?array $info, ?string $result)
    {
        if ($request != null) {
            $this->request = $request;
        }

        if ($info != null) {
            $this->info = $info;

            if (array_key_exists('url', $info)) {
                $this->url = $info['url'];
            }

            if (array_key_exists('http_code', $info)) {
                $this->statusCode = $info['http_code'];
            }

            if ($result != null) {
                $this->result = $result;
                if (array_key_exists('header_size', $info)) {
                    $this->headerSize = $info['header_size'];
                    $this->headers = substr($this->result, 0, $this->headerSize);
                    $this->body = substr($this->result, $this->headerSize);
                }
            }
        }
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return array|null
     */
    public function getInfo(): ?array
    {
        return $this->info;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
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
     * @return int|mixed|null
     */
    public function getHeaderSize()
    {
        return $this->headerSize;
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
        return $this->result;
    }

    /**
     * Convert the output header to array
     * @param string $str
     * @return array
     */
    public function headersToArray(string $str): array
    {
        $headers = array();
        $headersTmpArray = explode("\r\n", $str);
        for ($i = 0 ; $i < count($headersTmpArray) ; ++$i) {
            // we don't care about the two \r\n lines at the end of the headers
            if (strlen($headersTmpArray[$i]) > 0) {
                // the headers start with HTTP status codes, which do not contain a colon, so we can filter them out too
                if (strpos($headersTmpArray[$i], ":")) {
                    $headerName = substr($headersTmpArray[$i], 0, strpos($headersTmpArray[$i], ":"));
                    $headerValue = substr($headersTmpArray[$i], strpos($headersTmpArray[$i], ":") + 2);
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }
}
