<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelOffer.
 * @see \Amadeus\Resources\HotelOffer::getPrice()
 */
class HotelProductHotelPrice implements ResourceInterface
{
    private ?string $currency = null;
    private ?string $sellingTotal = null;
    private ?string $total = null;
    private ?string $base = null;
    private ?array $taxes = null;
    private ?array $markups = null;
    private ?object $variations = null;

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return string|null
     */
    public function getSellingTotal(): ?string
    {
        return $this->sellingTotal;
    }

    /**
     * @return string|null
     */
    public function getTotal(): ?string
    {
        return $this->total;
    }

    /**
     * @return string|null
     */
    public function getBase(): ?string
    {
        return $this->base;
    }

    /**
     * @return HotelOfferTax[]|null
     */
    public function getTaxes(): ?array
    {
        return Resource::toResourceArray(
            $this->taxes,
            HotelOfferTax::class
        );
    }

    /**
     * @return Markup[]|null
     */
    public function getMarkups(): ?array
    {
        return Resource::toResourceArray(
            $this->markups,
            Markup::class
        );
    }

    /**
     * @return HotelProductPriceVariations|null
     */
    public function getVariations(): ?object
    {
        return Resource::toResourceObject(
            $this->variations,
            HotelProductPriceVariations::class
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
