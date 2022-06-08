<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\Client\BasicHTTPClient;
use Amadeus\Client\HTTPClient;

class Amadeus
{
    private Configuration $configuration;

    private HTTPClient $client;

    private Airport $airport;

    private Shopping $shopping;

    private ReferenceData $referenceData;

    /**
     * @param Configuration $configuration
     */
    public function __construct(
        Configuration $configuration
    ) {
        $this->configuration = $configuration;

        $this->client = new BasicHTTPClient($configuration);

        $this->airport = new Airport($this);
        $this->shopping = new Shopping($this);
        $this->referenceData = new ReferenceData($this);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return Configuration
     */
    // TODO  AmadeuBuilder class
    public static function builder(string $clientId, string $clientSecret): Configuration
    {
        return new Configuration($clientId, $clientSecret);
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return BasicHTTPClient|HTTPClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return Airport
     */
    public function getAirport(): Airport
    {
        return $this->airport;
    }

    /**
     * @return Shopping
     */
    public function getShopping(): Shopping
    {
        return $this->shopping;
    }

    /**
     * @return ReferenceData
     */
    public function getReferenceData(): ReferenceData
    {
        return $this->referenceData;
    }
}
