<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseAreaReport
 * @see DiseaseAreaReport
 */
class Area implements ResourceInterface
{
    private ?string $name = null;
    private ?string $iataCode = null;
    private ?string $geoCode = null;
    private ?string $areaType = null;

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
     * @return string|null
     */
    public function getGeoCode(): ?string
    {
        return $this->geoCode;
    }

    /**
     * @return string|null
     */
    public function getAreaType(): ?string
    {
        return $this->areaType;
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
