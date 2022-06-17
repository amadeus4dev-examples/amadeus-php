<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class HotelProductHoldPolicy implements ResourceInterface
{
    private ?string $deadline = null;

    /**
     * @return string|null
     */
    public function getDeadline(): ?string
    {
        return $this->deadline;
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
