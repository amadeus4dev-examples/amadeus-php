<?php

declare(strict_types=1);

namespace Amadeus;

class Amadeus extends HTTPClient
{
    public Airport $airport;

    public Shopping $shopping;

    public ReferenceData $referenceData;

    /**
     * @param Configuration $configuration
     */
    public function __construct(
        Configuration $configuration
    ) {
        parent::__construct($configuration);

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
