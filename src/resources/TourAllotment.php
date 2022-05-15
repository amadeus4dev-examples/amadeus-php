<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class TourAllotment implements ResourceInterface
{
    private ?string $tourName = null;
    private ?string $tourReference = null;
    private ?string $mode = null;
    private ?string $remainingSeats = null;

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
     * @return string|null
     */
    public function getRemainingSeats(): ?string
    {
        return $this->remainingSeats;
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
