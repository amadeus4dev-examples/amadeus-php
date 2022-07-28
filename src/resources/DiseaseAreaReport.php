<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A DiseaseAreaReport object as returned by the Travel Restrictions API.
 * @see Covid19AreaReport::get()
 * @see https://developers.amadeus.com/self-service/category/covid-19-and-travel-safety/api-doc/travel-restrictions/api-reference
 */
class DiseaseAreaReport extends Resource implements ResourceInterface
{
    private ?object $area = null;
    private ?array $subAreas = null;
    private ?string $summary = null;
    private ?string $diseaseRiskLevel = null;
    private ?object $diseaseInfection = null;
    private ?object $diseaseCases = null;
    private ?string $hotspots = null;
    private ?object $dataSources = null;
    private ?array $areaRestrictions = null;
    private ?object $areaAccessRestriction = null;
    private ?object $areaPolicy = null;
    private ?array $relatedArea = null;
    private ?array $areaVaccinated = null;
    private ?string $type = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return Area|null
     */
    public function getArea(): ?object
    {
        return Resource::toResourceObject(
            $this->area,
            Area::class
        );
    }

    /**
     * @return array|null
     */
    public function getSubAreas(): ?array
    {
        return $this->subAreas;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @return string|null
     */
    public function getDiseaseRiskLevel(): ?string
    {
        return $this->diseaseRiskLevel;
    }

    /**
     * @return DiseaseInfection|null
     */
    public function getDiseaseInfection(): ?object
    {
        return Resource::toResourceObject(
            $this->diseaseInfection,
            DiseaseInfection::class
        );
    }

    /**
     * @return DiseaseCase|null
     */
    public function getDiseaseCases(): ?object
    {
        return Resource::toResourceObject(
            $this->diseaseCases,
            DiseaseCase::class
        );
    }

    /**
     * @return string|null
     */
    public function getHotspots(): ?string
    {
        return $this->hotspots;
    }

    /**
     * @return DiseaseDataSources|null
     */
    public function getDataSources(): ?object
    {
        return Resource::toResourceObject(
            $this->dataSources,
            DiseaseDataSources::class
        );
    }

    /**
     * @return AreaRestriction[]|null
     */
    public function getAreaRestrictions(): ?array
    {
        return Resource::toResourceArray(
            $this->areaRestrictions,
            AreaRestriction::class
        );
    }

    /**
     * @return AreaAccessRestriction|null
     */
    public function getAreaAccessRestriction(): ?object
    {
        return Resource::toResourceObject(
            $this->areaAccessRestriction,
            AreaAccessRestriction::class
        );
    }

    /**
     * @return AreaPolicy|null
     */
    public function getAreaPolicy(): ?object
    {
        return Resource::toResourceObject(
            $this->areaPolicy,
            AreaPolicy::class
        );
    }

    /**
     * @return Link[]|null
     */
    public function getRelatedArea(): ?array
    {
        return Resource::toResourceArray(
            $this->relatedArea,
            Link::class
        );
    }

    /**
     * @return AreaVaccinated[]|null
     */
    public function getAreaVaccinated(): ?array
    {
        return Resource::toResourceArray(
            $this->areaVaccinated,
            AreaVaccinated::class
        );
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
