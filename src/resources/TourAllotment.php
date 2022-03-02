<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class TourAllotment
{
    private string $tourName;
    private string $tourReference;
    private string $mode;
    private string $remainingSeats;

    /**
     * @return string
     */
    public function getTourName(): string
    {
        return $this->tourName;
    }

    /**
     * @return string
     */
    public function getTourReference(): string
    {
        return $this->tourReference;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getRemainingSeats(): string
    {
        return $this->remainingSeats;
    }

}