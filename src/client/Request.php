<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Constants;

class Request
{
    private string $verb;

    private string $scheme;

    private string $host;

    private string $path;

    private ?array $params;

    private ?string $body;

    private ?string $bearerToken;

    private ?string $languageVersion;

    private bool $ssl;

    private int $port;

    private ?string $sslCertificate;

    private string $uri;

    private array $headers;

    /**
     * @param string $verb
     * @param string $path
     * @param array|null $params
     * @param string|null $body
     * @param string|null $bearerToken
     * @param HTTPClient $client
     */
    public function __construct(
        string $verb,
        string $path,
        ?array $params,
        ?string $body,
        ?string $bearerToken,
        HTTPClient $client
    ) {
        $config = $client->getConfiguration();

        $this->verb = $verb;
        $this->host = $config->getHost();
        $this->path = $path;
        $this->params = $params;
        $this->body = $body;
        $this->bearerToken = $bearerToken;
        $this->languageVersion = phpversion();
        $this->port = $config->getPort();
        $this->ssl = $config->isSsl();
        $this->sslCertificate = $client->getSslCertificate();

        $this->determineScheme();
        $this->prepareUrl();
        $this->prepareHeaders();
    }

    /**
     * @return void
     */
    private function determineScheme()
    {
        if ($this->isSsl()) {
            $this->scheme = Constants::HTTPS;
        } else {
            $this->scheme = Constants::HTTP;
        }
    }

    /**
     * @return void
     */
    private function prepareUrl(): void
    {
        $this->uri = $this->scheme."://".$this->host.":".$this->port
            .$this->path."?".$this->getQueryParams();
    }

    /**
     * @return void
     */
    private function prepareHeaders(): void
    {
        $this->headers = array();
        $this->headers[] = Constants::ACCEPT."application/json, application/vnd.amadeus+json";

        if ($this->bearerToken != null) {
            $this->headers[] = Constants::AUTHORIZATION.Constants::BEARER.$this->bearerToken;
            $this->headers[] = Constants::CONTENT_TYPE."application/vnd.amadeus+json";

            if (in_array($this->path, Constants::API_NEED_EXTRA_HEADER)
                && ($this->verb == Constants::POST)) {
                $this->headers[] = Constants::X_HTTP_METHOD_OVERRIDE.Constants::GET;
            }
        }
    }

    /**
     * @return string
     */
    private function getQueryParams(): string
    {
        if ($this->params != null) {
            return http_build_query($this->params);
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getBearerToken(): ?string
    {
        return $this->bearerToken;
    }

    /**
     * @return string|null
     */
    public function getLanguageVersion(): ?string
    {
        return $this->languageVersion;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string|null
     */
    public function getSslCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
