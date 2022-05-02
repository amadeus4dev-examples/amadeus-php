<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightOffer extends Resource
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $source = null;
    private ?bool $instantTicketingRequired = null;
    private ?bool $disablePricing = null;
    private ?bool $nonHomogenous = null;
    private ?bool $oneWay = null;
    private ?bool $paymentCardRequired = null;
    private ?string $lastTicketingDate = null;
    private ?int $numberOfBookableSeats = null;
    private ?array $itineraries = null;
    private ?object $price = null;
    private ?object $pricingOptions = null;
    private ?array $validatingAirlineCodes = null;
    private ?array $travelerPricings = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return bool|null
     */
    public function getInstantTicketingRequired(): ?bool
    {
        return $this->instantTicketingRequired;
    }

    /**
     * @return bool|null
     */
    public function getDisablePricing(): ?bool
    {
        return $this->disablePricing;
    }

    /**
     * @return bool|null
     */
    public function getNonHomogenous(): ?bool
    {
        return $this->nonHomogenous;
    }

    /**
     * @return bool|null
     */
    public function getOneWay(): ?bool
    {
        return $this->oneWay;
    }

    /**
     * @return bool|null
     */
    public function getPaymentCardRequired(): ?bool
    {
        return $this->paymentCardRequired;
    }

    /**
     * @return string|null
     */
    public function getLastTicketingDate(): ?string
    {
        return $this->lastTicketingDate;
    }

    /**
     * @return int|null
     */
    public function getNumberOfBookableSeats(): ?int
    {
        return $this->numberOfBookableSeats;
    }

    /**
     * @return Itineraries[]|null
     */
    public function getItineraries(): ?array
    {
        return Resource::toResourceArray(
            $this->itineraries,
            Itineraries::class
        );
    }

    /**
     * @return Price|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            Price::class
        );
    }

    /**
     * @return PricingOptions|null
     */
    public function getPricingOptions(): ?object
    {
        return Resource::toResourceObject(
            $this->pricingOptions,
            PricingOptions::class
        );
    }

    /**
     * @return array|null
     */
    public function getValidatingAirlineCodes(): ?array
    {
        return $this->validatingAirlineCodes;
    }

    /**
     * @return TravelerPricing[]|null
     */
    public function getTravelerPricings(): ?array
    {
        return Resource::toResourceArray(
            $this->travelerPricings,
            TravelerPricing::class
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
