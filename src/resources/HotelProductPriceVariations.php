<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelProductHotelPrice.
 * @see HotelProductHotelPrice::getVariations()
 */
class HotelProductPriceVariations implements ResourceInterface
{
    private ?object $average = null;
    private ?array $changes = null;

    /**
     * @return HotelOfferAveragePrice|null
     */
    public function getAverage(): ?object
    {
        return Resource::toResourceObject(
            $this->average,
            HotelOfferAveragePrice::class
        );
    }

    /**
     * @return HotelProductPriceVariation[]|null
     */
    public function getChanges(): ?array
    {
        return Resource::toResourceArray(
            $this->changes,
            HotelProductPriceVariation::class
        );
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
