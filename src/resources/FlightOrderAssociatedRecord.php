<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in FlightOrder.
 * @see FlightOrder::getAssociatedRecords()
 */
class FlightOrderAssociatedRecord implements ResourceInterface
{
    private ?string $reference = null;
    private ?string $creationDateTime = null;
    private ?string $originSystemCode = null;
    private ?string $flightOfferId = null;

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return string|null
     */
    public function getCreationDateTime(): ?string
    {
        return $this->creationDateTime;
    }

    /**
     * @return string|null
     */
    public function getOriginSystemCode(): ?string
    {
        return $this->originSystemCode;
    }

    /**
     * @return string|null
     */
    public function getFlightOfferId(): ?string
    {
        return $this->flightOfferId;
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
