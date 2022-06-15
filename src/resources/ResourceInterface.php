<?php

declare(strict_types=1);

namespace Amadeus\Resources;

interface ResourceInterface
{
    public function __set($name, $value): void;
    public function __toString(): ?string;
}
