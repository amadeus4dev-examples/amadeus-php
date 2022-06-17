<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductEstimatedRoomType implements ResourceInterface
{
    private ?string $category = null;
    private ?int $beds = null;
    private ?string $bedType = null;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return int|null
     */
    public function getBeds(): ?int
    {
        return $this->beds;
    }

    /**
     * @return string|null
     */
    public function getBedType(): ?string
    {
        return $this->bedType;
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
