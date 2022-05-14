<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Analytics
{
    private ?object $travelers = null;

    /**
     * @return object|null
     */
    public function getTravelers(): ?object
    {
        return $this->travelers;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
