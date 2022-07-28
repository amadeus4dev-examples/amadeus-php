<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in DiseaseAreaReport
 * @see DiseaseAreaReport::getAreaAccessRestriction()
 */
class AreaAccessRestriction implements ResourceInterface
{
    private ?object $transportation = null;
    private ?object $declarationDocuments = null;
    private ?object $entry = null;
    private ?object $diseaseTesting = null;
    private ?object $tracingApplication = null;
    private ?object $quarantineModality = null;
    private ?object $mask = null;
    private ?object $exit = null;
    private ?object $otherRestriction = null;
    private ?object $diseaseVaccination = null;

    /**
     * @return Transportation|null
     */
    public function getTransportation(): ?object
    {
        return Resource::toResourceObject(
            $this->transportation,
            Transportation::class
        );
    }

    /**
     * @return DeclarationDocuments|null
     */
    public function getDeclarationDocuments(): ?object
    {
        return Resource::toResourceObject(
            $this->declarationDocuments,
            DeclarationDocuments::class
        );
    }

    /**
     * @return EntryRestriction|null
     */
    public function getEntry(): ?object
    {
        return Resource::toResourceObject(
            $this->entry,
            EntryRestriction::class
        );
    }

    /**
     * @return DiseaseTestingRestriction|null
     */
    public function getDiseaseTesting(): ?object
    {
        return Resource::toResourceObject(
            $this->diseaseTesting,
            DiseaseTestingRestriction::class
        );
    }

    /**
     * @return DatedTracingApplicationRestriction|null
     */
    public function getTracingApplication(): ?object
    {
        return Resource::toResourceObject(
            $this->tracingApplication,
            DatedTracingApplicationRestriction::class
        );
    }

    /**
     * @return DatedQuarantineRestriction|null
     */
    public function getQuarantineModality(): ?object
    {
        return Resource::toResourceObject(
            $this->quarantineModality,
            DatedQuarantineRestriction::class
        );
    }

    /**
     * @return MaskRestriction|null
     */
    public function getMask(): ?object
    {
        return Resource::toResourceObject(
            $this->mask,
            MaskRestriction::class
        );
    }

    /**
     * @return ExitRestriction|null
     */
    public function getExit(): ?object
    {
        return Resource::toResourceObject(
            $this->exit,
            ExitRestriction::class
        );
    }

    /**
     * @return DatedInformation|null
     */
    public function getOtherRestriction(): ?object
    {
        return Resource::toResourceObject(
            $this->otherRestriction,
            DatedInformation::class
        );
    }

    /**
     * @return DiseaseVaccination|null
     */
    public function getDiseaseVaccination(): ?object
    {
        return Resource::toResourceObject(
            $this->diseaseVaccination,
            DiseaseVaccination::class
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
