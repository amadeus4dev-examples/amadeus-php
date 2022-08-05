<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Booking\FlightOrders;

/**
 * A FlightOrder object as returned by the Flight Create Orders API.
 * @see FlightOrders::post()
 * @see FlightOrders::postWithFlightOffersAndTravelers()
 * @link https://developers.amadeus.com/self-service/category/air/api-doc/flight-create-orders/api-reference
 */
class FlightOrder extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?string $queuingOfficeId = null;
    private ?array $associatedRecords = null;
    private ?array $travelers = null;
    private ?array $flightOffers = null;

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
    public function getQueuingOfficeId(): ?string
    {
        return $this->queuingOfficeId;
    }

    /**
     * @return FlightOrderAssociatedRecord[]|null
     */
    public function getAssociatedRecords(): ?array
    {
        return Resource::toResourceArray(
            $this->associatedRecords,
            FlightOrderAssociatedRecord::class
        );
    }

    /**
     * @return TravelerElement[]|null
     */
    public function getTravelers(): ?array
    {
        return Resource::toResourceArray(
            $this->travelers,
            TravelerElement::class
        );
    }

    /**
     * @return FlightOffer[]|null
     */
    public function getFlightOffers(): ?array
    {
        return Resource::toResourceArray(
            $this->flightOffers,
            FlightOffer::class
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
