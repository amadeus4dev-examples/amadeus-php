<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in Hotel, HotelNameAutocomplete, Activity, Location, Area, etc.
 * @see \Amadeus\Resources\Hotel::getGeoCode()
 * @see HotelNameAutocomplete::getGeoCode()
 * @see \Amadeus\Resources\Activity::getGeoCode()
 * @see \Amadeus\Resources\Location::getGeoCode()
 * @see Area::getGeoCode()
 */
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

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
