<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class PricingOptions implements ResourceInterface
{
    private ?array $fareType = null;
    private ?bool $includedCheckedBagsOnly = null;
    private ?bool $refundableFare = null;
    private ?bool $noRestrictionFare = null;
    private ?bool $noPenaltyFare = null;

    /**
     * @return array|null
     */
    public function getFareType(): ?array
    {
        return $this->fareType;
    }

    /**
     * @return bool|null
     */
    public function getIncludedCheckedBagsOnly(): ?bool
    {
        return $this->includedCheckedBagsOnly;
    }

    /**
     * @return bool|null
     */
    public function getRefundableFare(): ?bool
    {
        return $this->refundableFare;
    }

    /**
     * @return bool|null
     */
    public function getNoRestrictionFare(): ?bool
    {
        return $this->noRestrictionFare;
    }

    /**
     * @return bool|null
     */
    public function getNoPenaltyFare(): ?bool
    {
        return $this->noPenaltyFare;
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
