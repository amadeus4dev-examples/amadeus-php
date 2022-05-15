<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Price implements ResourceInterface
{
    private ?string $margin = null;
    private ?string $grandTotal = null;
    private ?string $billingCurrency = null;
    private ?array $additionalServices = null;
    private ?string $currency = null;
    private ?string $total = null;
    private ?string $base = null;
    private ?array $fees = null;
    private ?array $taxes = null;
    private ?string $refundableTaxes = null;

    /**
     * @return string|null
     */
    public function getMargin(): ?string
    {
        return $this->margin;
    }

    /**
     * @return string|null
     */
    public function getGrandTotal(): ?string
    {
        return $this->grandTotal;
    }

    /**
     * @return string|null
     */
    public function getBillingCurrency(): ?string
    {
        return $this->billingCurrency;
    }

    /**
     * @return AdditionalService[]|null
     */
    public function getAdditionalServices(): ?array
    {
        return Resource::toResourceArray(
            $this->additionalServices,
            AdditionalService::class
        );
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
     * @return Fee[]|null
     */
    public function getFees(): ?array
    {
        return Resource::toResourceArray(
            $this->fees,
            Fee::class
        );
    }

    /**
     * @return Tax[]|null
     */
    public function getTaxes(): ?array
    {
        return Resource::toResourceArray(
            $this->taxes,
            Tax::class
        );
    }

    /**
     * @return string|null
     */
    public function getRefundableTaxes(): ?string
    {
        return $this->refundableTaxes;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
