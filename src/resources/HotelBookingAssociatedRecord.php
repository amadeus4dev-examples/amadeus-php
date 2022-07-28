<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelBookingLight.
 * @see HotelBookingLight::getAssociatedRecords()
 */
class HotelBookingAssociatedRecord implements ResourceInterface
{
    private ?string $reference = null;
    private ?string $originSystemCode = null;

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return string|null
     */
    public function getOriginSystemCode(): ?string
    {
        return $this->originSystemCode;
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
