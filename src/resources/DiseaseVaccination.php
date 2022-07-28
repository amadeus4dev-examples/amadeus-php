<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction::getDiseaseVaccination()
 */
class DiseaseVaccination implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $isRequired = null;
    private ?string $referenceLink = null;
    private ?array $acceptedCertificates = null;
    private ?array $qualifiedVaccines = null;
    private ?string $policy = null;
    private ?string $exemptions = null;
    private ?string $details = null;

    /**
     * @return string|null
     */
    public function getIsRequired(): ?string
    {
        return $this->isRequired;
    }

    /**
     * @return string|null
     */
    public function getReferenceLink(): ?string
    {
        return $this->referenceLink;
    }

    /**
     * @return array|null
     */
    public function getAcceptedCertificates(): ?array
    {
        return $this->acceptedCertificates;
    }

    /**
     * @return array|null
     */
    public function getQualifiedVaccines(): ?array
    {
        return $this->qualifiedVaccines;
    }

    /**
     * @return string|null
     */
    public function getPolicy(): ?string
    {
        return $this->policy;
    }

    /**
     * @return string|null
     */
    public function getExemptions(): ?string
    {
        return $this->exemptions;
    }

    /**
     * @return string|null
     */
    public function getDetails(): ?string
    {
        return $this->details;
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
