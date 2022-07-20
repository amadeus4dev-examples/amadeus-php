<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightOffer, FlightDestination etc.
 * @see FlightOffer, FlightDestination
 */
class FlightPrice implements ResourceInterface
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
     * @return FlightAdditionalService[]|null
     */
    public function getAdditionalServices(): ?array
    {
        return Resource::toResourceArray(
            $this->additionalServices,
            FlightAdditionalService::class
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
     * @return FlightFee[]|null
     */
    public function getFees(): ?array
    {
        return Resource::toResourceArray(
            $this->fees,
            FlightFee::class
        );
    }

    /**
     * @return FlightOfferTax[]|null
     */
    public function getTaxes(): ?array
    {
        return Resource::toResourceArray(
            $this->taxes,
            FlightOfferTax::class
        );
    }

    /**
     * @return string|null
     */
    public function getRefundableTaxes(): ?string
    {
        return $this->refundableTaxes;
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
