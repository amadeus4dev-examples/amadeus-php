<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A Destination object as returned by the Airport Routes API.
 * @see DirectDestinations::get()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference
 */
class Destination extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $subtype = null;
    private ?string $name = null;
    private ?string $iataCode = null;

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
    public function getSubtype(): ?string
    {
        return $this->subtype;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getIataCode(): ?string
    {
        return $this->iataCode;
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
