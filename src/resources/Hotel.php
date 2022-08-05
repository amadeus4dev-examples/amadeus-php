<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A Hotel object as returned by the Hotel List API.
 * @see ByCity::get()
 * @see ByGeocode::get()
 * @see ByHotels::get()
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference
 */
class Hotel extends Resource implements ResourceInterface
{
    private ?string $chainCode = null;
    private ?string $iataCode = null;
    private ?float $dupeId = null;
    private ?string $subtype = null;
    private ?string $name = null;
    private ?string $hotelId = null;
    private ?string $timeZoneName = null;
    private ?object $geoCode = null;
    private ?object $address = null;
    private ?object $distance = null;
    private ?string $googlePlaceId = null;
    private ?string $openjetAirportId = null;
    private ?string $uicCode = null;
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

    /**
     * @return float|null
     */
    public function getDupeId(): ?float
    {
        return $this->dupeId;
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
