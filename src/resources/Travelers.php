<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Travelers implements ResourceInterface
{
    private ?string $score = null;

    /**
     * @return string|null
     */
    public function getScore(): ?string
    {
        return $this->score;
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
