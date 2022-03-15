<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightStop
{
    private ?string $iataCode = null;
    private ?string $duration = null;
    private ?string $arrivalAt = null;
    private ?string $departureAt = null;

    /**
     * @param object $object
     */
    public function __construct(object $object)
    {
        foreach($object as $key =>  $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return string|null
     */
    public function getArrivalAt(): ?string
    {
        return $this->arrivalAt;
    }

    /**
     * @return string|null
     */
    public function getDepartureAt(): ?string
    {
        return $this->departureAt;
    }

}