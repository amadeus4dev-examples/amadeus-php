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
     * @param object $object
     */
    public function __construct(object $object)
    {
        foreach($object as $key =>  $value)
        {
            $this->$key = $value;
        }
    }

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

}