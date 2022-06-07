<?php

declare(strict_types=1);

namespace Amadeus;

class Amadeus
{
    public Configuration $configuration;

    public HTTPClient $client;

    public Airport $airport;

    public Shopping $shopping;

    public ReferenceData $referenceData;

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
    public static function builder(string $clientId, string $clientSecret): Configuration
    {
        return new Configuration($clientId, $clientSecret);
    }
}
