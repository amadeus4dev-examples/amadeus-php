<?php declare(strict_types=1);

namespace Amadeus\Resources;

class OperatingFlight
{
    private ?string $carrierCode = null;

    /**
     * @return string|null
     */
    public function getCarrierCode(): ?string
    {
        return $this->carrierCode;
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