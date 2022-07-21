<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in TermAnaCondition
 * @see TermAndCondition
 */
class Description implements ResourceInterface
{
    private ?string $descriptionType = null;
    private ?string $text = null;

    /**
     * @return string|null
     */
    public function getDescriptionType(): ?string
    {
        return $this->descriptionType;
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
