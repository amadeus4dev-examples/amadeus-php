<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class TourAllotment
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

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this))."\n";
    }

}