<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class GeoCode implements ResourceInterface
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

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this));
    }
}
