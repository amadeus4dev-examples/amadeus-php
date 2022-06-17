<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelNameAutocomplete extends Resource implements ResourceInterface
{
    private ?int $id = null;
    private ?string $type = null;
    private ?string $name = null;
    private ?string $iataCode = null;
    private ?array $hotelIds = null;
    private ?string $subType = null;
    private ?object $address = null;
    private ?object $geoCode = null;
    private ?int $relevance = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
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
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return array|null
     */
    public function getHotelIds(): ?array
    {
        return $this->hotelIds;
    }

    /**
     * @return string|null
     */
    public function getSubType(): ?string
    {
        return $this->subType;
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
     * @return int|null
     */
    public function getRelevance(): ?int
    {
        return $this->relevance;
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
