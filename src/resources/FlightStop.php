<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightStop implements ResourceInterface
{
    private ?string $iataCode = null;
    private ?string $duration = null;
    private ?string $arrivalAt = null;
    private ?string $departureAt = null;

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

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        return Resource::toString(get_object_vars($this));
    }
}
