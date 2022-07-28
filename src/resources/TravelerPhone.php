<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in TravelerContact
 * @see TravelerContact::getPhones()
 */
class TravelerPhone implements ResourceInterface
{
    private ?string $deviceType = null;
    private ?string $countryCallingCode = null;
    private ?string $number = null;

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @return string|null
     */
    public function getCountryCallingCode(): ?string
    {
        return $this->countryCallingCode;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
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
