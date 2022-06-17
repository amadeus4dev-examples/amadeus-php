<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductGuaranteePolicy implements ResourceInterface
{
    private ?object $description = null;
    private ?object $acceptedPayments = null;

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
