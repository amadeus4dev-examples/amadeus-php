<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductCheckInOutPolicy implements ResourceInterface
{
    private ?string $checkIn = null;
    private ?object $checkInDescription = null;
    private ?string $checkOut = null;
    private ?object $checkOutDescription = null;

    /**
     * @return string|null
     */
    public function getCheckIn(): ?string
    {
        return $this->checkIn;
    }

    /**
     * @return QualifiedFreeText|null
     */
    public function getCheckInDescription(): ?object
    {
        return Resource::toResourceObject(
            $this->checkInDescription,
            QualifiedFreeText::class
        );
    }

    /**
     * @return string|null
     */
    public function getCheckOut(): ?string
    {
        return $this->checkOut;
    }

    /**
     * @return QualifiedFreeText|null
     */
    public function getCheckOutDescription(): ?object
    {
        return Resource::toResourceObject(
            $this->checkOutDescription,
            QualifiedFreeText::class
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
