<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class Tax implements ResourceInterface
{
    private ?string $amount = null;
    private ?string $code = null;

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
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
