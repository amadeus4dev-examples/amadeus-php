<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Itineraries
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

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
