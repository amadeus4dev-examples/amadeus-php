<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * Sub-resource in AreaAccessRestriction
 * @see AreaAccessRestriction
 */
class DatedTracingApplicationRestriction implements ResourceInterface
{
    private ?string $date = null;
    private ?string $text = null;
    private ?string $isRequired = null;
    private ?array $iosUrl = null;
    private ?array $androidUrl = null;
    private ?string $website = null;

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

    /**
     * @return array|null
     */
    public function getIosUrl(): ?array
    {
        return $this->iosUrl;
    }

    /**
     * @return array|null
     */
    public function getAndroidUrl(): ?array
    {
        return $this->androidUrl;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
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
