<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelOfferTax implements ResourceInterface
{
    private ?string $currency = null;
    private ?string $amount = null;
    private ?string $code = null;
    private ?string $percentage = null;
    private ?bool $included = null;
    private ?string $description = null;
    private ?string $pricingFrequency = null;
    private ?string $pricingMode = null;

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
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    /**
     * @return bool|null
     */
    public function getIncluded(): ?bool
    {
        return $this->included;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getPricingFrequency(): ?string
    {
        return $this->pricingFrequency;
    }

    /**
     * @return string|null
     */
    public function getPricingMode(): ?string
    {
        return $this->pricingMode;
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
