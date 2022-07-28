<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Shopping\FlightOffers\Pricing;

/**
 * Optional parameter resource for calling Flight Offer Price API.
 * @see Pricing::postWithFlightOffers()
 */
class FlightPayment implements ResourceInterface
{
    private ?string $brand = null;
    private ?int $binNumber = null;
    private ?array $flightOfferIds = null;

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @return int|null
     */
    public function getBinNumber(): ?int
    {
        return $this->binNumber;
    }

    /**
     * @return array|null
     */
    public function getFlightOfferIds(): ?array
    {
        return $this->flightOfferIds;
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
