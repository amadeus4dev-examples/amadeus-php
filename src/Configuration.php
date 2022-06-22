<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;

class Configuration
{
    /**
     * The client ID used to authenticate the API calls.
     */
    private string $clientId;

    /**
     * The client secret used to authenticate the API calls.
     */
    private string $clientSecret;

    /**
     * The optional custom host domain to use for API calls.
     * Defaults to "test.api.amadeus.com" for a test environment,
     * and "api.amadeus.com" for a production environment.
     */
    private string $host = "test.api.amadeus.com";

    /**
     * Whether to use SSL. Defaults to true
     */
    private bool $ssl = true;

    /**
     * The port to use. Defaults to 443 for an SSL connection, and 80 for a non SSL connection.
     */
    private int $port = 443;

    /**
     * The http client to use. Defaults to BasicHTTPClient within the SDK.
     */
    private ?HTTPClient $httpClient = null;

    /**
     * The maximum number of seconds to allow cURL functions to execute. Defaults to 20.
     */
    private int $timeout = 20;

    //private ?bool $logger = false;
    //private ?int $msgType = null;
    //private ?string $msgDestination = null;

    /**
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct(
        string $clientId,
        string $clientSecret
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param bool $ssl
     * @return Configuration
     */
    public function setSsl(bool $ssl): Configuration
    {
        $this->ssl = $ssl;
        if (!$ssl && $this->port == 443) {
            $this->setPort(80);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @param int $port
     * @return void
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param HTTPClient $httpClient
     */
    public function setHttpClient(HTTPClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return HTTPClient
     */
    public function getHttpClient(): HTTPClient
    {
        return (is_null($this->httpClient)) ? new BasicHTTPClient($this) : $this->httpClient;
    }

    /**
     * Build for production environment
     */
    public function setProductionEnvironment(): Configuration
    {
        $this->host = 'api.amadeus.com';
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    // TODO LOGGER FUNCTION NEEDS TO BE REVIEWED
//    /**
//     * @param string|null $msgDestination
//     * @return Configuration
//     */
//    public function setLogger(?string $msgDestination=null): Configuration
//    {
//        $this->logger = true;
//        if ($msgDestination != null) {
//            $this->msgType = 3;
//        } else {
//            $this->msgType = 0;
//        }
//        $this->msgDestination = $msgDestination;
//        return $this;
//    }
//
//    /**
//     * @return bool|null
//     */
//    public function getLogger(): ?bool
//    {
//        return $this->logger;
//    }
//
//    /**
//     * @return int|null
//     */
//    public function getMsgType(): ?int
//    {
//        return $this->msgType;
//    }
//
//    /**
//     * @return string|null
//     */
//    public function getMsgDestination(): ?string
//    {
//        return $this->msgDestination;
//    }
}
