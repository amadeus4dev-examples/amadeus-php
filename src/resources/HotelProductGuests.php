<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductGuests implements ResourceInterface
{
    private ?int $adults = null;
    private ?array $childAges = null;

    /**
     * @return int|null
     */
    public function getAdults(): ?int
    {
        return $this->adults;
    }

    /**
     * @return array|null
     */
    public function getChildAges(): ?array
    {
        return $this->childAges;
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
