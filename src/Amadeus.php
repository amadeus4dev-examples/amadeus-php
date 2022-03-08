<?php declare(strict_types=1);

namespace Amadeus;

use JsonMapper_Exception;

class Amadeus extends HTTPClient
{
    public Airport $airport;

    public Shopping $shopping;

    /**
     * @throws JsonMapper_Exception
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