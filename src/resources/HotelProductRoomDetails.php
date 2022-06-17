<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductRoomDetails implements ResourceInterface
{
    private ?string $type = null;
    private ?object $typeEstimated = null;
    private ?object $description = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return HotelProductEstimatedRoomType|null
     */
    public function getTypeEstimated(): ?object
    {
        return Resource::toResourceObject(
            $this->typeEstimated,
            HotelProductEstimatedRoomType::class
        );
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

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
