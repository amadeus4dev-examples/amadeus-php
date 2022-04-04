<?php declare(strict_types=1);

namespace Amadeus;

class Configuration
{
    private string $clientId;

    private string $clientSecret;

    private string $base_url;

    private ?bool $logger;
    private ?int $msgType;
    private ?string $msgDestination;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $base_url
     * @param bool|null $logger
     * @param int|null $msgType
     * @param string|null $msgDestination
     */
    public function __construct
    (
        string $clientId,
        string $clientSecret,
        string $base_url = 'https://test.api.amadeus.com',
        ?bool $logger = false,
        ?int $msgType = null,
        ?string $msgDestination = null
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->base_url = $base_url;
        $this->logger = $logger;
        $this->msgType = $msgType;
        $this->msgDestination = $msgDestination;
    }

    /**
     * @return Amadeus
     */
    public function build(): Amadeus
    {
        return new Amadeus($this);
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
    public function getBaseUrl(): string
    {
        return $this->base_url;
    }

    /**
     * Build for production environment
     */
    public function setProductionEnvironment(): Configuration
    {
        $this->base_url = 'https://api.amadeus.com';
        return new Configuration($this->clientId, $this->clientSecret, $this->base_url);
    }

    /**
     * @param int $msgType
     * @param string|null $msgDestination
     * @return Configuration
     */
    public function setLogger(int $msgType, ?string $msgDestination=null): Configuration
    {
        $this->logger = true;
        $this->msgType = $msgType;
        $this->msgDestination = $msgDestination;
        return new Configuration($this->clientId, $this->clientSecret, $this->base_url,
            $this->logger, $this->msgType, $this->msgDestination);
    }

    /**
     * @return bool|null
     */
    public function getLogger(): ?bool
    {
        return $this->logger;
    }

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