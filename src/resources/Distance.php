<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Distance
{
    private ?int $value = null;
    private ?string $unit = null;

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
