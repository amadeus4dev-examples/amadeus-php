<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelAddress implements ResourceInterface
{
    private ?string $category = null;
    private ?array $lines = null;
    private ?string $postalCode = null;
    private ?string $cityName = null;
    private ?string $countryCode = null;
    private ?string $stateCode = null;
    private ?string $postalBox = null;
    private ?string $text = null;
    private ?string $state = null;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

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
    public function getStateCode(): ?string
    {
        return $this->stateCode;
    }

    /**
     * @return string|null
     */
    public function getPostalBox(): ?string
    {
        return $this->postalBox;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
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
