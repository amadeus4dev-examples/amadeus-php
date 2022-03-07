<?php declare(strict_types=1);

namespace Amadeus;

use JsonMapper_Exception;

class Configuration
{
    private string $clientId;

    private string $clientSecret;

    /**
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return Amadeus
     * @throws JsonMapper_Exception
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

}