<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AdditionalServicesRequest
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