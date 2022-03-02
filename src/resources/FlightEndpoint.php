<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightEndpoint
{
    private string $iataCode;
    private string $terminal;
    private string $at;

    /**
     * @return string
     */
    public function getIataCode(): string
    {
        return $this->iataCode;
    }

    /**
     * @return string
     */
    public function getTerminal(): string
    {
        return $this->terminal;
    }

    /**
     * @return string
     */
    public function getAt(): string
    {
        return $this->at;
    }

}
