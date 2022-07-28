<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in TravelerContact
 * @see TravelerContact::getAddress()
 */
class TravelerAddress implements ResourceInterface
{
    private ?array $lines = null;
    private ?string $postalCode = null;
    private ?string $countryCode = null;
    private ?string $cityName = null;
    private ?string $stateName = null;
    private ?string $postalBox = null;

    /**
     * @return array|null
     */
    public function getLines(): ?array
    {
        return $this->lines;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @return string|null
     */
    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    /**
     * @return string|null
     */
    public function getStateName(): ?string
    {
        return $this->stateName;
    }

    /**
     * @return string|null
     */
    public function getPostalBox(): ?string
    {
        return $this->postalBox;
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
