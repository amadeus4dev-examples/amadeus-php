<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction
 */
class ExitRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $specialRequirements = null;
    private ?string $rulesLink = null;
    private ?string $isBanned = null;

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
    public function getSpecialRequirements(): ?string
    {
        return $this->specialRequirements;
    }

    /**
     * @return string|null
     */
    public function getRulesLink(): ?string
    {
        return $this->rulesLink;
    }

    /**
     * @return string|null
     */
    public function getIsBanned(): ?string
    {
        return $this->isBanned;
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
