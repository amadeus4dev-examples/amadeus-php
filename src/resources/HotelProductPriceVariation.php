<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductPriceVariation implements ResourceInterface
{
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $currency = null;
    private ?string $sellingTotal = null;
    private ?string $base = null;
    private ?string $total = null;
    private ?array $markups = null;

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

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
    public function getBase(): ?string
    {
        return $this->base;
    }

    /**
     * @return string|null
     */
    public function getTotal(): ?string
    {
        return $this->total;
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

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
