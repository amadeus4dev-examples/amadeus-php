<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class GeoCode
{
    private ?float $latitude = null;
    private ?float $longitude = null;

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
