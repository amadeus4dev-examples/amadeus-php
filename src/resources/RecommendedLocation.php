<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A RecommendedLocation-related object as returned by the Travel Recommendations API
 * @see 
 * @see https://developers.amadeus.com/self-service/category/trip/api-doc/travel-recommendations/api-reference
 */
class RecommendedLocation extends Resource implements ResourceInterface
{
    private ?string $subtype = null;
    private ?string $name = null;
    private ?string $iataCode = null;
    private ?object $geoCode = null;
    private ?string $type = null;
    private ?float $relevance = null;

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
    public function getIataCode(): ?string
    {
        return $this->iataCode;
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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return float|null
     */
    public function getRelevance(): ?float
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
