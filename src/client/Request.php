<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Constants;

/**
 * An object containing all the details of the request made, including the host,
 * path, port, params, and headers. Generally this object can be accessed as part of
 * an API response, and can be used to debug the API call made.
 */
class Request
{
    /**
     * The HTTPClient verb to use for API calls.
     */
    private string $verb;

    /**
     * The scheme to use for API calls.
     */
    private string $scheme;

    /**
     * The host domain to use for API calls.
     */
    private string $host;

    /**
     * The path use for API calls.
     */
    private string $path;

    /**
     * The params to send to the API endpoint.
     */
    private ?array $params;

    /**
     * The body to send to the API endpoint.
     */
    private ?string $body;

    /**
     * The bearer token used to authenticate the API call.
     */
    private ?string $bearerToken;

    /**
     * The version of PHP used.
     */
    private ?string $languageVersion;

    /**
     * Whether this connection uses SSL.
     */
    private bool $ssl;

    /**
     * The port to use for this request.
     */
    private int $port;

    /**
     * The SSL certificate to use for this request.
     */
    private ?string $sslCertificate;

    /**
     * The full URI for this request, based on the
     * verb, port, path, host, etc.
     */
    private string $uri;

    /**
     * The headers for this request.
     */
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
     * Determines the scheme based on the SSL value
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
     * Prepares the full URL based on the scheme, host, port and path.
     * @return void
     */
    private function prepareUrl(): void
    {
        if (($this->params != null) && ($this->bearerToken != null)) {
            $this->uri = $this->scheme."://".$this->host.":".$this->port
                .$this->path."?".http_build_query($this->params);
        } else {
            $this->uri = $this->scheme."://".$this->host.":".$this->port
                .$this->path;
        }
    }

    /**
     * Prepares the headers to be sent in the request
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
