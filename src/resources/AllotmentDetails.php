<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class AllotmentDetails implements ResourceInterface
{
    private ?string $tourName = null;
    private ?string $tourReference = null;

    /**
     * @return string|null
     */
    public function getTourName(): ?string
    {
        return $this->tourName;
    }

    /**
     * @return string|null
     */
    public function getTourReference(): ?string
    {
        return $this->tourReference;
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
