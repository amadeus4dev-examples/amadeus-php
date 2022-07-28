<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelOffer, HotelProductRoomDetails, HotelProductCommission,
 * HotelProductCheckInOutPolicy, HotelProductGuaranteePolicy,
 * HotelProductDepositPolicy, HotelProductCancellationPolicy.
 * @see \Amadeus\Resources\HotelOffer::getDescription()
 * @see HotelProductRoomDetails::getDescription()
 * @see HotelProductCommission::getDescription()
 * @see HotelProductCheckInOutPolicy::getDescription()
 * @see HotelProductGuaranteePolicy::getDescription()
 * @see HotelProductDepositPolicy::getDescription()
 * @see HotelProductCancellationPolicy::getDescription()
 */
class QualifiedFreeText implements ResourceInterface
{
    private ?string $text = null;
    private ?string $lang = null;

    /**
     * @return string|null
     */
    public function getLang(): ?string
    {
        return $this->lang;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
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
