<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseAreaReport
 * @see DiseaseAreaReport
 */
class AreaVaccinated implements ResourceInterface
{
    private ?string $date = null;
    private ?string $vaccinationDoseStatus = null;
    private ?float $percentage = null;
    private ?string $text = null;

    /**
     * @return string|null
     */
    public function getVaccinationDoseStatus(): ?string
    {
        return $this->vaccinationDoseStatus;
    }

    /**
     * @return float|null
     */
    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
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
