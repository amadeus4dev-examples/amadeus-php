<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction
 */
class DeclarationDocuments implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $documentRequired = null;
    private ?string $healthDocumentationLink = null;
    private ?string $travelDocumentationLink = null;

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

    /**
     * @return string|null
     */
    public function getDocumentRequired(): ?string
    {
        return $this->documentRequired;
    }

    /**
     * @return string|null
     */
    public function getHealthDocumentationLink(): ?string
    {
        return $this->healthDocumentationLink;
    }

    /**
     * @return string|null
     */
    public function getTravelDocumentationLink(): ?string
    {
        return $this->travelDocumentationLink;
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
