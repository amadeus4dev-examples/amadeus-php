<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A HotelBookingLight object as returned by the Hotel Booking API.
 * @see HotelBookings::post()
 * @link https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference
 */
class HotelBookingLight extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $providerConfirmationId  = null;
    private ?array $associatedRecords = null;

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
    public function getProviderConfirmationId(): ?string
    {
        return $this->providerConfirmationId;
    }

    /**
     * @return HotelBookingAssociatedRecord[]|null
     */
    public function getAssociatedRecords(): ?array
    {
        return Resource::toResourceArray(
            $this->associatedRecords,
            HotelBookingAssociatedRecord::class
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
