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
