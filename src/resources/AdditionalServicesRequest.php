<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AdditionalServicesRequest implements ResourceInterface
{
    private ?object $chargeableCheckedBags = null;
    private ?string $chargeableSeatNumber = null;
    private ?array $otherServices = null;

    /**
     * @return object|null
     */
    public function getChargeableCheckedBags(): ?object
    {
        return $this->chargeableCheckedBags;
    }

    /**
     * @return string|null
     */
    public function getChargeableSeatNumber(): ?string
    {
        return $this->chargeableSeatNumber;
    }

    /**
     * @return array|null
     */
    public function getOtherServices(): ?array
    {
        return $this->otherServices;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
