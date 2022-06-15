<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AircraftEquipment implements ResourceInterface
{
    private ?string $code = null;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
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
