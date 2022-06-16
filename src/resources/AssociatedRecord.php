<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AssociatedRecord implements ResourceInterface
{
    private ?string $reference = null;
    private ?string $creationDate = null;
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
    public function getCreationDate(): ?string
    {
        return $this->creationDate;
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
