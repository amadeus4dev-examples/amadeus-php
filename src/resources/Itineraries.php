<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Itineraries implements ResourceInterface
{
    private ?string $duration = null;
    private ?array $segments = null;

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @return ExtendedSegment[]|null
     */
    public function getSegments(): ?array
    {
        return Resource::toResourceArray(
            $this->segments,
            ExtendedSegment::class
        );
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        return Resource::toString(get_object_vars($this));
    }
}
