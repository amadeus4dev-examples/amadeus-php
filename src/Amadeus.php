<?php declare(strict_types=1);

namespace Amadeus;

use Amadeus\Exceptions\ResponseException;

class Amadeus extends HTTPClient
{
    public Airport $airport;

    public Shopping $shopping;

    /**
     * @param Configuration $configuration
     */
    public function __construct
    (
        Configuration $configuration
    )
    {
        parent::__construct($configuration);

        $this->airport = new Airport($this);
        $this->shopping = new Shopping($this);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return Configuration
     */
    public static function builder(string $clientId, string $clientSecret): Configuration
    {
        return new Configuration($clientId,$clientSecret);
    }
}