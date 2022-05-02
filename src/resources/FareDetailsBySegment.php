<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class FareDetailsBySegment
{
    private ?string $segmentId = null;
    private ?string $cabin = null;
    private ?string $fareBasis = null;
    private ?string $brandedFare = null;
    private ?string $class = null;
    private ?bool $isAllotment = null;
    private ?object $allotmentDetails = null;
    private ?string $sliceDiceIndicator = null;
    private ?object $includedCheckedBags = null;
    private ?object $additionalServices = null;

    /**
     * @return string|null
     */
    public function getSegmentId(): ?string
    {
        return $this->segmentId;
    }

    /**
     * @return string|null
     */
    public function getCabin(): ?string
    {
        return $this->cabin;
    }

    /**
     * @return string|null
     */
    public function getFareBasis(): ?string
    {
        return $this->fareBasis;
    }

    /**
     * @return string|null
     */
    public function getBrandedFare(): ?string
    {
        return $this->brandedFare;
    }

    /**
     * @return string|null
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @return bool|null
     */
    public function getIsAllotment(): ?bool
    {
        return $this->isAllotment;
    }

    /**
     * @return AllotmentDetails|null
     */
    public function getAllotmentDetails(): ?object
    {
        return Resource::toResourceObject(
            $this->allotmentDetails,
            AllotmentDetails::class
        );
    }

    /**
     * @return string|null
     */
    public function getSliceDiceIndicator(): ?string
    {
        return $this->sliceDiceIndicator;
    }

    /**
     * @return BaggageAllowance|null
     */
    public function getIncludedCheckedBags(): ?object
    {
        return Resource::toResourceObject(
            $this->includedCheckedBags,
            BaggageAllowance::class
        );
    }

    /**
     * @return object|null
     */
    public function getAdditionalServices(): ?object
    {
        return Resource::toResourceObject(
            $this->additionalServices,
            AdditionalServicesRequest::class
        );
    }

    // Setter
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
