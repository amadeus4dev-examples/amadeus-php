<?php declare(strict_types=1);

namespace Amadeus;

class Response
{
    private ?object $result = null;

    private ?string $url = null;
    private ?int $statusCode = null;

    /**
     * @param array|null $info
     * @param object|null $result
     */
    public function __construct(?array $info, ?object $result)
    {
        if($info != null)
        {
            if(array_key_exists('url', $info)) $this->url = $info['url'];
            if(array_key_exists('http_code', $info)) $this->statusCode = $info['http_code'];
        }

        if($result != null)
        {
            $this->result = $result;
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
     * @return null|object
     */
    public function getResult(): ?object
    {
        return $this->result;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->result->{'data'};
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}