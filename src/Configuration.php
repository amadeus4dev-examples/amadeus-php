<?php

declare(strict_types=1);

namespace Amadeus;

class Configuration
{
    private string $clientId;

    private string $clientSecret;

    private string $host = "test.api.amadeus.com";

    private bool $ssl = true;

    private int $port = 443;

    private ?bool $logger = false;
    private ?int $msgType = null;
    private ?string $msgDestination = null;

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
     * @return Amadeus
     */
    public function build(): Amadeus
    {
        return new Amadeus($this);
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
     * @param int $port
     * @return void
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
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
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
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

    /**
     * @return int|null
     */
    public function getMsgType(): ?int
    {
        return $this->msgType;
    }

    /**
     * @return string|null
     */
    public function getMsgDestination(): ?string
    {
        return $this->msgDestination;
    }
}
