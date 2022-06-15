<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class TravelerPricing implements ResourceInterface
{
    private ?string $travelerId = null;
    private ?string $fareOption = null;
    private ?string $travelerType = null;
    private ?string $associateAdultId = null;
    private ?object $price = null;
    private ?array $fareDetailsBySegment = null;

    /**
     * @return string|null
     */
    public function getTravelerId(): ?string
    {
        return $this->travelerId;
    }

    /**
     * @return string|null
     */
    public function getFareOption(): ?string
    {
        return $this->fareOption;
    }

    /**
     * @return string|null
     */
    public function getTravelerType(): ?string
    {
        return $this->travelerType;
    }

    /**
     * @return string|null
     */
    public function getAssociateAdultId(): ?string
    {
        return $this->associateAdultId;
    }

    /**
     * @return Price|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            Price::class
        );
    }

    /**
     * @return FareDetailsBySegment[]|null
     */
    public function getFareDetailsBySegment(): ?array
    {
        return Resource::toResourceArray(
            $this->fareDetailsBySegment,
            FareDetailsBySegment::class
        );
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
