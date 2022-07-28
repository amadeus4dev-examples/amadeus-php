<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in EntryRestriction
 * @see EntryRestriction::getBorderBan()
 */
class Border implements ResourceInterface
{
    private ?string $borderType = null;
    private ?string $status = null;

    /**
     * @return string|null
     */
    public function getBorderType(): ?string
    {
        return $this->borderType;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
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
