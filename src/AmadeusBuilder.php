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
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): AmadeusBuilder
    {
        $this->configuration->setHost($host);
        return $this;
    }

    /**
     * @param bool $ssl
     * @return AmadeusBuilder
     */
    public function setSsl(bool $ssl): AmadeusBuilder
    {
        $this->configuration->setSsl($ssl);
        return $this;
    }

    /**
     * @param int $port
     * @return AmadeusBuilder
     */
    public function setPort(int $port): AmadeusBuilder
    {
        $this->configuration->setPort($port);
        return $this;
    }

    /**
     * @param HTTPClient $httpClient
     * @return AmadeusBuilder
     */
    public function setHttpClient(HTTPClient $httpClient): AmadeusBuilder
    {
        $this->configuration->setHttpClient($httpClient);
        return $this;
    }

    /**
     * @return AmadeusBuilder
     */
    public function setProductionEnvironment(): AmadeusBuilder
    {
        $this->configuration->setProductionEnvironment();
        return $this;
    }

    /**
     * @return Amadeus
     */
    public function build(): Amadeus
    {
        return new Amadeus($this->configuration);
    }
}
