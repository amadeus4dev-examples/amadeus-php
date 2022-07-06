<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\HTTPClient;

class AmadeusBuilder
{
    private Configuration $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Set the optional custom host domain to use for API calls.
     * Defaults to "test.api.amadeus.com" for a test environment,
     * and "api.amadeus.com" for a production environment.
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): AmadeusBuilder
    {
        $this->configuration->setHost($host);
        return $this;
    }

    /**
     * Whether to use SSL. Defaults to true
     * @param bool $ssl
     * @return AmadeusBuilder
     */
    public function setSsl(bool $ssl): AmadeusBuilder
    {
        $this->configuration->setSsl($ssl);
        return $this;
    }

    /**
     * Set the port to use. Defaults to 443 for an SSL connection, and 80 for a non SSL connection.
     * @param int $port
     * @return AmadeusBuilder
     */
    public function setPort(int $port): AmadeusBuilder
    {
        $this->configuration->setPort($port);
        return $this;
    }

    /**
     * Set the http client to use. Defaults to BasicHTTPClient.
     * @param HTTPClient $httpClient
     * @return AmadeusBuilder
     */
    public function setHttpClient(HTTPClient $httpClient): AmadeusBuilder
    {
        $this->configuration->setHttpClient($httpClient);
        return $this;
    }

    /**
     * Set to production environment.
     * @return AmadeusBuilder
     */
    public function setProductionEnvironment(): AmadeusBuilder
    {
        $this->configuration->setProductionEnvironment();
        return $this;
    }

    /**
     * Set the maximum number of seconds to allow cURL functions to execute.
     * @param int $timeout
     * @return $this
     */
    public function setTimeout(int $timeout): AmadeusBuilder
    {
        $this->configuration->setTimeout($timeout);
        return $this;
    }

    /**
     * Return a Amadeus object.
     * @return Amadeus
     */
    public function build(): Amadeus
    {
        return new Amadeus($this->configuration);
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}
