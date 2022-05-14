<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Travelers
{
    private ?string $score = null;

    /**
     * @return string|null
     */
    public function getScore(): ?string
    {
        return $this->score;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
