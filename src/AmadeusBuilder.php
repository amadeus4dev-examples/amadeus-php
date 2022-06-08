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
     * @param bool $ssl
     * @return $this
     */
    public function setSsl(bool $ssl): AmadeusBuilder
    {
        $this->configuration->setSsl($ssl);
        return $this;
    }

    public function setPort(int $port): AmadeusBuilder
    {
        $this->configuration->setPort($port);
        return $this;
    }

    public function setHttpClient(HTTPClient $httpClient): AmadeusBuilder
    {
        $this->configuration->setHttpClient($httpClient);
        return $this;
    }

    public function setProductionEnvironment(): AmadeusBuilder
    {
        $this->configuration->setProductionEnvironment();
        return $this;
    }

    public function build(): Amadeus
    {
        return new Amadeus($this->configuration);
    }
}
