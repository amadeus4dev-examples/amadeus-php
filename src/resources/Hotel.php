<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Hotel extends Resource implements ResourceInterface
{
    private ?string $subtype = null;
    private ?string $name = null;
    private ?string $timeZoneName = null;
    private ?string $iataCode = null;
    private ?object $address = null;
    private ?object $geoCode = null;
    private ?string $googlePlaceId = null;
    private ?string $openjetAirportId = null;
    private ?string $uicCode = null;
    private ?string $hotelId = null;
    private ?string $chainCode = null;
    private ?object $distance = null;
    private ?string $last_update = null;

    /**
     * @return string|null
     */
    public function getSubtype(): ?string
    {
        return $this->subtype;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTimeZoneName(): ?string
    {
        return $this->timeZoneName;
    }

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return HotelAddress|null
     */
    public function getAddress(): ?object
    {
        return Resource::toResourceObject(
            $this->address,
            HotelAddress::class
        );
    }

    /**
     * @return GeoCode|null
     */
    public function getGeoCode(): ?object
    {
        return Resource::toResourceObject(
            $this->geoCode,
            GeoCode::class
        );
    }

    /**
     * @return string|null
     */
    public function getGooglePlaceId(): ?string
    {
        return $this->googlePlaceId;
    }

    /**
     * @return string|null
     */
    public function getOpenjetAirportId(): ?string
    {
        return $this->openjetAirportId;
    }

    /**
     * @return string|null
     */
    public function getUicCode(): ?string
    {
        return $this->uicCode;
    }

    /**
     * @return string|null
     */
    public function getHotelId(): ?string
    {
        return $this->hotelId;
    }

    /**
     * @return string|null
     */
    public function getChainCode(): ?string
    {
        return $this->chainCode;
    }

    /**
     * @return HotelDistance|null
     */
    public function getDistance(): ?object
    {
        return Resource::toResourceObject(
            $this->distance,
            HotelDistance::class
        );
    }

    /**
     * @return string|null
     */
    public function getLastUpdate(): ?string
    {
        return $this->last_update;
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
