<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightStop
{
    private string $iataCode;
    private string $duration;
    private string $arrivalAt;
    private string $departureAt;

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
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getArrivalAt(): string
    {
        return $this->arrivalAt;
    }

    /**
     * @return string
     */
    public function getDepartureAt(): string
    {
        return $this->departureAt;
    }

}