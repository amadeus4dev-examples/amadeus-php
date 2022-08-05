<?php

declare(strict_types=1);

namespace Amadeus\Resources;

use Amadeus\Shopping\Activities;

/**
 * An Activity-related object as returned by the Tours and Activities API.
 * @see Activities::get()
 * @see \Amadeus\Shopping\Activity::get()
 * @link https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference
 */
class Activity extends Resource implements ResourceInterface
{
    private ?string $type = null;
    private ?string $id = null;
    private ?object $self = null;
    private ?string $name = null;
    private ?string $shortDescription = null;
    private ?string $description = null;
    private ?object $geoCode = null;
    private ?string $rating = null;
    private ?object $price = null;
    private ?array $pictures = null;
    private ?string $bookingLink = null;
    private ?string $minimumDuration = null;

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
     * @return Link|null
     */
    public function getSelf(): ?object
    {
        return Resource::toResourceObject(
            $this->self,
            Link::class
        );
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return GeoCode|null
     */
    public function getGeoCode(): ?object
    {
        return Resource::toResourceObject(
            $this->geoCode,
            GeoCode::class
        );
    }

    /**
     * @return string|null
     */
    public function getRating(): ?string
    {
        return $this->rating;
    }

    /**
     * @return ElementaryPrice|null
     */
    public function getPrice(): ?object
    {
        return Resource::toResourceObject(
            $this->price,
            ElementaryPrice::class
        );
    }

    /**
     * @return array|null
     */
    public function getPictures(): ?array
    {
        return $this->pictures;
    }

    /**
     * @return string|null
     */
    public function getBookingLink(): ?string
    {
        return $this->bookingLink;
    }

    /**
     * @return string|null
     */
    public function getMinimumDuration(): ?string
    {
        return $this->minimumDuration;
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
