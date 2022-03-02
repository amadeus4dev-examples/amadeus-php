<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class AvailabilityClass
{
    private int $numberOfBookableSeats;
    private string $class;
    private string $closedStatus;
    private TourAllotment $tourAllotment;

    /**
     * @return int
     */
    public function getNumberOfBookableSeats(): int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getClosedStatus(): string
    {
        return $this->closedStatus;
    }

    /**
     * @return TourAllotment
     */
    public function getTourAllotment(): TourAllotment
    {
        return $this->tourAllotment;
    }

}