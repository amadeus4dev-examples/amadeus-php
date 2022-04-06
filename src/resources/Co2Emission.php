<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Co2Emission
{
    private ?int $weight = null;
    private ?string $weightUnit = null;
    private ?string $cabin = null;

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @return string|null
     */
    public function getWeightUnit(): ?string
    {
        return $this->weightUnit;
    }

    /**
     * @return string|null
     */
    public function getCabin(): ?string
    {
        return $this->cabin;
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
