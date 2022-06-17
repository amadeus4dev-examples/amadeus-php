<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelOffer implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $checkInDate = null;
    private ?string $checkOutDate = null;
    private ?int $roomQuantity = null;
    private ?string $rateCode = null;
    private ?object $rateFamilyEstimated = null;
    private ?string $category = null;
    private ?object $description = null;
    private ?object $commission = null;
    private ?string $boardType = null;
    private ?object $room = null;
    private ?object $guests = null;
    private ?object $price = null;
    private ?object $policies = null;
    private ?string $self = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCheckInDate(): ?string
    {
        return $this->checkInDate;
    }

    /**
     * @return string|null
     */
    public function getCheckOutDate(): ?string
    {
        return $this->checkOutDate;
    }

    /**
     * @return int|null
     */
    public function getRoomQuantity(): ?int
    {
        return $this->roomQuantity;
    }

    /**
     * @return string|null
     */
    public function getRateCode(): ?string
    {
        return $this->rateCode;
    }

    /**
     * @return HotelProductRateFamily|null
     */
    public function getRateFamilyEstimated(): ?object
    {
        return Resource::toResourceObject(
            $this->rateFamilyEstimated,
            HotelProductRateFamily::class
        );
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
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
     * @return HotelProductCommission|null
     */
    public function getCommission(): ?object
    {
        return Resource::toResourceObject(
            $this->commission,
            HotelProductCommission::class
        );
    }

    /**
     * @return string|null
     */
    public function getBoardType(): ?string
    {
        return $this->boardType;
    }

    /**
     * @return HotelProductRoomDetails|null
     */
    public function getRoom(): ?object
    {
        return Resource::toResourceObject(
            $this->room,
            HotelProductRoomDetails::class
        );
    }

    /**
     * @return HotelProductGuests|null
     */
    public function getGuests(): ?object
    {
        return Resource::toResourceObject(
            $this->guests,
            HotelProductGuests::class
        );
    }

    /**
     * @return HotelProductHotelPrice|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            HotelProductHotelPrice::class
        );
    }

    /**
     * @return HotelProductPolicyDetails|null
     */
    public function getPolicies(): ?object
    {
        return Resource::toResourceObject(
            $this->policies,
            HotelProductHotelPrice::class
        );
    }

    /**
     * @return string|null
     */
    public function getSelf(): ?string
    {
        return $this->self;
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
