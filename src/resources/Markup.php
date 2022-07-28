<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelOfferAveragePrice, HotelProductPriceVariation, HotelProductHotelPrice.
 * @see HotelOfferAveragePrice::getMarkups()
 * @see HotelProductPriceVariation::getMarkups()
 * @see HotelProductHotelPrice::getMarkups()
 */
class Markup implements ResourceInterface
{
    private ?string $amount = null;

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
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
