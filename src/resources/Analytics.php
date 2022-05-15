<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Analytics implements ResourceInterface
{
    private ?object $travelers = null;

    /**
     * @return object|null
     */
    public function getTravelers(): ?object
    {
        return $this->travelers;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}
