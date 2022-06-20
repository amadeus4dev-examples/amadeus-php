<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A FlightOfferPricingOutput object as returned by the Flight Offers Price API.
 * @see Pricing
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference
 */
class FlightOfferPricingOutput extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?array $flightOffers = null;
    private ?object $bookingRequirements = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return FlightOffer[]|null
     */
    public function getFlightOffers(): ?array
    {
        return Resource::toResourceArray(
            $this->flightOffers,
            FlightOffer::class
        );
    }

    /**
     * @return FlightBookingRequirements|null
     */
    public function getBookingRequirements(): ?object
    {
        return Resource::toResourceObject(
            $this->bookingRequirements,
            FlightBookingRequirements::class
        );
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
