<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightEndpoint implements ResourceInterface
{
    private ?string $iataCode = null;
    private ?string $terminal = null;
    private ?string $at = null;

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
    public function getTerminal(): ?string
    {
        return $this->terminal;
    }

    /**
     * @return string|null
     */
    public function getAt(): ?string
    {
        return $this->at;
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
