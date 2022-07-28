<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelOffer.
 * @see \Amadeus\Resources\HotelOffer::getPolicies()
 */
class HotelProductPolicyDetails implements ResourceInterface
{
    private ?string $paymentType = null;
    private ?object $guarantee = null;
    private ?object $deposit = null;
    private ?object $prepay = null;
    private ?object $holdTime = null;
    private ?object $cancellation = null;
    private ?object $checkInOut = null;

    /**
     * @return string|null
     */
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @return HotelProductGuaranteePolicy|null
     */
    public function getGuarantee(): ?object
    {
        return Resource::toResourceObject(
            $this->guarantee,
            HotelProductGuaranteePolicy::class
        );
    }

    /**
     * @return HotelProductDepositPolicy|null
     */
    public function getDeposit(): ?object
    {
        return Resource::toResourceObject(
            $this->deposit,
            HotelProductDepositPolicy::class
        );
    }

    /**
     * @return HotelProductDepositPolicy|null
     */
    public function getPrepay(): ?object
    {
        return Resource::toResourceObject(
            $this->prepay,
            HotelProductDepositPolicy::class
        );
    }

    /**
     * @return HotelProductHoldPolicy|null
     */
    public function getHoldTime(): ?object
    {
        return Resource::toResourceObject(
            $this->holdTime,
            HotelProductHoldPolicy::class
        );
    }

    /**
     * @return HotelProductCancellationPolicy|null
     */
    public function getCancellation(): ?object
    {
        return Resource::toResourceObject(
            $this->cancellation,
            HotelProductCancellationPolicy::class
        );
    }

    /**
     * @return HotelProductCheckInOutPolicy|null
     */
    public function getCheckInOut(): ?object
    {
        return Resource::toResourceObject(
            $this->checkInOut,
            HotelProductCheckInOutPolicy::class
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
