<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelProductPolicyDetails.
 * @see HotelProductPolicyDetails::getDeposit()
 */
class HotelProductDepositPolicy implements ResourceInterface
{
    private ?string $amount = null;
    private ?string $deadline = null;
    private ?object $description = null;
    private ?object $acceptedPayments = null;

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
    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    /**
     * @return QualifiedFreeText|null
     */
    public function getDescription(): ?object
    {
        return Resource::toResourceObject(
            $this->description,
            QualifiedFreeText::class
        );
    }

    /**
     * @return HotelProductPaymentPolicy|null
     */
    public function getAcceptedPayments(): ?object
    {
        return Resource::toResourceObject(
            $this->acceptedPayments,
            HotelProductPaymentPolicy::class
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
