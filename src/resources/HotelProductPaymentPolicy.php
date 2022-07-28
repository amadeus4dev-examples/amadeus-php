<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelProductGuaranteePolicy, HotelProductDepositPolicy.
 * @see HotelProductGuaranteePolicy::getAcceptedPayments()
 * @see HotelProductDepositPolicy::getAcceptedPayments()
 */
class HotelProductPaymentPolicy implements ResourceInterface
{
    private ?array $creditCards = null;
    private ?array $methods = null;

    /**
     * @return array|null
     */
    public function getCreditCards(): ?array
    {
        return $this->creditCards;
    }

    /**
     * @return array|null
     */
    public function getMethods(): ?array
    {
        return $this->methods;
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
