<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class OperatingFlight implements ResourceInterface
{
    private ?string $carrierCode = null;

    /**
     * @return string|null
     */
    public function getCarrierCode(): ?string
    {
        return $this->carrierCode;
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        return Resource::toString(get_object_vars($this));
    }
}
