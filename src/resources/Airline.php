<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\ReferenceData\Airlines;

/**
 * An Airline object as returned by the Airline Code Lookup API.
 * @see Airlines
 * @see https://developers.amadeus.com/self-service/category/air/api-doc/airline-code-lookup/api-reference
 */
class Airline extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $iataCode = null;
    private ?string $icaoCode = null;
    private ?string $businessName = null;
    private ?string $commonName = null;

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
    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    /**
     * @return string|null
     */
    public function getIcaoCode(): ?string
    {
        return $this->icaoCode;
    }

    /**
     * @return string|null
     */
    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    /**
     * @return string|null
     */
    public function getCommonName(): ?string
    {
        return $this->commonName;
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
