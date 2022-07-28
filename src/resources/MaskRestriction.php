<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction::getMask()
 */
class MaskRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $isRequired = null;

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
    public function getIsRequired(): ?string
    {
        return $this->isRequired;
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
