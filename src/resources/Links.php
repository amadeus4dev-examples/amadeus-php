<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Links
{
    private ?string $href = null;
    private ?array $methods = null;
    private ?int $count = null;

    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @return array|null
     */
    public function getMethods(): ?array
    {
        return $this->methods;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
