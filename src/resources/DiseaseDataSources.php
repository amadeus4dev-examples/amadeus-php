<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseAreaReport
 * @see DiseaseAreaReport
 */
class DiseaseDataSources implements ResourceInterface
{
    private ?string $covidDashboardLink = null;
    private ?string $healthDepartmentLink = null;
    private ?string $governmentSiteLink = null;

    /**
     * @return string|null
     */
    public function getCovidDashboardLink(): ?string
    {
        return $this->covidDashboardLink;
    }

    /**
     * @return string|null
     */
    public function getHealthDepartmentLink(): ?string
    {
        return $this->healthDepartmentLink;
    }

    /**
     * @return string|null
     */
    public function getGovernmentSiteLink(): ?string
    {
        return $this->governmentSiteLink;
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
