<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Shopping\FlightOffers;
use Amadeus\Shopping\FlightOffers\Prediction;

/**
 * A FlightOffer object as returned by the Flight Offers Search API, Flight Choice Prediction API.
 * @see FlightOffers::get()
 * @see FlightOffers::post()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
 * @see Prediction::post()
 * @see Prediction::postWithFlightOffers()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-choice-prediction/api-reference
 */
class FlightOffer extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $source = null;
    private ?bool $instantTicketingRequired = null;
    private ?bool $disablePricing = null;
    private ?bool $nonHomogeneous = null;
    private ?bool $oneWay = null;
    private ?string $lastTicketingDate = null;
    private ?int $numberOfBookableSeats = null;
    private ?array $itineraries = null;
    private ?object $price = null;
    private ?object $pricingOptions = null;
    private ?array $validatingAirlineCodes = null;
    private ?array $travelerPricings = null;
    private ?bool $paymentCardRequired = null;
    private ?string $choiceProbability = null;
    private ?object $fareRules = null;

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
    public function getNonHomogeneous(): ?bool
    {
        return $this->nonHomogeneous;
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
     * @return FlightItineraries[]|null
     */
    public function getItineraries(): ?array
    {
        return Resource::toResourceArray(
            $this->itineraries,
            FlightItineraries::class
        );
    }

    /**
     * @return FlightPrice|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            FlightPrice::class
        );
    }

    /**
     * @return FlightPricingOptions|null
     */
    public function getPricingOptions(): ?object
    {
        return Resource::toResourceObject(
            $this->pricingOptions,
            FlightPricingOptions::class
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

    /**
     * @return string|null
     */
    public function getChoiceProbability(): ?string
    {
        return $this->choiceProbability;
    }

    /**
     * @return FareRules|null
     */
    public function getFareRules(): ?object
    {
        return Resource::toResourceObject(
            $this->fareRules,
            FareRules::class
        );
    }

    public function __set($name, $value): void
    {
        $this->$name = $value;
    }

    public function __toString(): string
    {
        return Resource::toString(get_object_vars($this));
    }
}
