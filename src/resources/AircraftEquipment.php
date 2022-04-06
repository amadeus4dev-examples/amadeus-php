<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AircraftEquipment
{
    private ?string $code = null;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
