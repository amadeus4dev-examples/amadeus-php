<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction::getEntry()
 */
class EntryRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $ban = null;
    private ?string $throughDate = null;
    private ?string $rules = null;
    private ?string $exemptions = null;
    private ?array $bannedArea = null;
    private ?array $borderBan = null;

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
    public function getBan(): ?string
    {
        return $this->ban;
    }

    /**
     * @return string|null
     */
    public function getThroughDate(): ?string
    {
        return $this->throughDate;
    }

    /**
     * @return string|null
     */
    public function getRules(): ?string
    {
        return $this->rules;
    }

    /**
     * @return string|null
     */
    public function getExemptions(): ?string
    {
        return $this->exemptions;
    }

    /**
     * @return Area[]|null
     */
    public function getBannedArea(): ?array
    {
        return Resource::toResourceArray(
            $this->bannedArea,
            Area::class
        );
    }

    /**
     * @return Border[]|null
     */
    public function getBorderBan(): ?array
    {
        return Resource::toResourceArray(
            $this->borderBan,
            Border::class
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
