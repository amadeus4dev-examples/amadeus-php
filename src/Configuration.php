<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;

class Configuration
{
    private string $clientId;

    private string $clientSecret;

    private string $host = "test.api.amadeus.com";

    private bool $ssl = true;

    private int $port = 443;

    private ?HTTPClient $httpClient = null;

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
