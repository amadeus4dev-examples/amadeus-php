<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in HotelSentiment
 * @see HotelSentiment::getSentiments()
 */
class HotelSentimentDetails implements ResourceInterface
{
    private ?int $staff = null;
    private ?int $location = null;
    private ?int $service = null;
    private ?int $roomComforts = null;
    private ?int $internet = null;
    private ?int $sleepQuality = null;
    private ?int $valueForMoney = null;
    private ?int $facilities = null;
    private ?int $catering = null;
    private ?int $pointsOfInterest = null;
    private ?int $swimmingPool = null;

    /**
     * @return int|null
     */
    public function getStaff(): ?int
    {
        return $this->staff;
    }

    /**
     * @return int|null
     */
    public function getLocation(): ?int
    {
        return $this->location;
    }

    /**
     * @return int|null
     */
    public function getService(): ?int
    {
        return $this->service;
    }

    /**
     * @return int|null
     */
    public function getRoomComforts(): ?int
    {
        return $this->roomComforts;
    }

    /**
     * @return int|null
     */
    public function getInternet(): ?int
    {
        return $this->internet;
    }

    /**
     * @return int|null
     */
    public function getSleepQuality(): ?int
    {
        return $this->sleepQuality;
    }

    /**
     * @return int|null
     */
    public function getValueForMoney(): ?int
    {
        return $this->valueForMoney;
    }

    /**
     * @return int|null
     */
    public function getFacilities(): ?int
    {
        return $this->facilities;
    }

    /**
     * @return int|null
     */
    public function getCatering(): ?int
    {
        return $this->catering;
    }

    /**
     * @return int|null
     */
    public function getPointsOfInterest(): ?int
    {
        return $this->pointsOfInterest;
    }

    /**
     * @return int|null
     */
    public function getSwimmingPool(): ?int
    {
        return $this->swimmingPool;
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
