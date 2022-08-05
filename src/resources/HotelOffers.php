<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A HotelOffers object as returned by the Hotel Search API.
 * @see \Amadeus\Shopping\HotelOffer::get()
 * @see \Amadeus\Shopping\HotelOffers::get()
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference
 */
class HotelOffers extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?object $hotel = null;
    private ?bool $available = null;
    private ?array $offers = null;
    private ?string $self = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return HotelContent|null
     */
    public function getHotel(): ?object
    {
        return Resource::toResourceObject(
            $this->hotel,
            HotelContent::class
        );
    }

    /**
     * @return bool|null
     */
    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    /**
     * @return HotelOffer[]|null
     */
    public function getOffers(): ?array
    {
        return Resource::toResourceArray(
            $this->offers,
            HotelOffer::class
        );
    }

    /**
     * @return string|null
     */
    public function getSelf(): ?string
    {
        return $this->self;
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
