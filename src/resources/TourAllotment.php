<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class TourAllotment implements ResourceInterface
{
    private ?string $tourName = null;
    private ?string $tourReference = null;
    private ?string $mode = null;
    private ?int $remainingSeats = null;

    /**
     * @return string|null
     */
    public function getTourName(): ?string
    {
        return $this->tourName;
    }

    /**
     * @return string|null
     */
    public function getTourReference(): ?string
    {
        return $this->tourReference;
    }

    /**
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }

    /**
     * @return int|null
     */
    public function getRemainingSeats(): ?int
    {
        return $this->remainingSeats;
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
