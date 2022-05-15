<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Location extends Resource implements ResourceInterface
{
    private ?string $id = null;
    private ?object $self = null;
    private ?string $type = null;
    private ?string $subType = null;
    private ?string $name = null;
    private ?string $detailedName = null;
    private ?string $timeZoneOffset = null;
    private ?string $iataCode = null;
    private ?object $geoCode = null;
    private ?object $address = null;
    private ?object $distance = null;
    private ?object $analytics = null;
    private ?float $relevance = null;
    private ?string $category = null;
    private ?string $tags = null;
    private ?string $rank = null;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return object|null
     */
    public function getSelf(): ?object
    {
        return Resource::toResourceObject(
            $this->self,
            Links::class
        );
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
    public function getSubType(): ?string
    {
        return $this->subType;
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
    public function getDetailedName(): ?string
    {
        return $this->detailedName;
    }

    /**
     * @return string|null
     */
    public function getTimeZoneOffset(): ?string
    {
        return $this->timeZoneOffset;
    }

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return object|null
     */
    public function getGeoCode(): ?object
    {
        return Resource::toResourceObject(
            $this->geoCode,
            GeoCode::class
        );
    }

    /**
     * @return object|null
     */
    public function getAddress(): ?object
    {
        return Resource::toResourceObject(
            $this->address,
            Address::class
        );
    }

    /**
     * @return object|null
     */
    public function getDistance(): ?object
    {
        return Resource::toResourceObject(
            $this->distance,
            Distance::class
        );
    }

    /**
     * @return object|null
     */
    public function getAnalytics(): ?object
    {
        return Resource::toResourceObject(
            $this->analytics,
            Analytics::class
        );
    }

    /**
     * @return float|null
     */
    public function getRelevance(): ?float
    {
        return $this->relevance;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @return string|null
     */
    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
