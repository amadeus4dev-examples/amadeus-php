<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AvailabilityClass implements ResourceInterface
{
    private ?int $numberOfBookableSeats = null;
    private ?string $class = null;
    private ?string $closedStatus = null;
    private ?object $tourAllotment = null;

    /**
     * @return int|null
     */
    public function getNumberOfBookableSeats(): ?int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @return string|null
     */
    public function getClosedStatus(): ?string
    {
        return $this->closedStatus;
    }

    /**
     * @return TourAllotment|null
     */
    public function getTourAllotment(): ?object
    {
        return Resource::toResourceObject(
            $this->tourAllotment,
            TourAllotment::class
        );
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
