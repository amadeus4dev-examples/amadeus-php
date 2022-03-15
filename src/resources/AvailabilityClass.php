<?php

/**
 * @noinspection PhpPropertyOnlyWrittenInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace Amadeus\Resources;

class AvailabilityClass
{
    private ?int $numberOfBookableSeats = null;
    private ?string $class = null;
    private ?string $closedStatus = null;
    private ?object $tourAllotment = null;

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
     * @return object|null
     */
    public function getTourAllotment(): ?object
    {
        return Resource::toResourceObject(
            $this->tourAllotment, TourAllotment::class
        );
    }

}