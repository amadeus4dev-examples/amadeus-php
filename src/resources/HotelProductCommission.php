<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductCommission implements ResourceInterface
{
    private ?string $percentage = null;
    private ?string $amount = null;
    private ?object $description = null;

    /**
     * @return string|null
     */
    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
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
