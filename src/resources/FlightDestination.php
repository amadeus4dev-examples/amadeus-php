<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Shopping\FlightDestinations;

/**
 * A FlightDestination object as returned by the Flight Inspiration Search API.
 * @see FlightDestinations::get()
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/flight-inspiration-search/api-reference
 */
class FlightDestination extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $origin = null;
    private ?string $destination = null;
    private ?string $departureDate = null;
    private ?string $returnDate = null;
    private ?object $price = null;
    private ?object $links = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @return string|null
     */
    public function getDepartureDate(): ?string
    {
        return $this->departureDate;
    }

    /**
     * @return string|null
     */
    public function getReturnDate(): ?string
    {
        return $this->returnDate;
    }

    /**
     * @return FlightPrice|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            FlightPrice::class
        );
    }

    /**
     * @return FlightDestinationLinks|null
     */
    public function getLinks(): ?object
    {
        return Resource::toResourceObject(
            $this->links,
            FlightDestinationLinks::class
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
