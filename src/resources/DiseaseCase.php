<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseAreaReport
 * @see DiseaseAreaReport
 */
class DiseaseCase implements ResourceInterface
{
    private ?string $date = null;
    private ?int $active = null;
    private ?int $recovered = null;
    private ?int $deaths = null;
    private ?int $confirmed = null;

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return int|null
     */
    public function getActive(): ?int
    {
        return $this->active;
    }

    /**
     * @return int|null
     */
    public function getRecovered(): ?int
    {
        return $this->recovered;
    }

    /**
     * @return int|null
     */
    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    /**
     * @return int|null
     */
    public function getConfirmed(): ?int
    {
        return $this->confirmed;
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
