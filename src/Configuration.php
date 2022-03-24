<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Exceptions\ResponseException;
use Exception;

class Configuration
{
    private string $clientId;

    private string $clientSecret;

    private string $base_url;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $base_url
     */
    public function __construct
    (
        string $clientId,
        string $clientSecret,
        string $base_url = 'https://test.api.amadeus.com'
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->base_url = $base_url;
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
}