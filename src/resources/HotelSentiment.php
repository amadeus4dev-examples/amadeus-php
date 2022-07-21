<?php

declare(strict_types=1);

namespace Amadeus\Resources;

/**
 * A HotelSentiment object as returned by the Hotel Ratings API.
 * @see HotelSentiments
 * @see https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-ratings/api-reference
 */
class HotelSentiment extends Resource implements ResourceInterface
{
    private ?string $hotelId = null;
    private ?int $overallRating = null;
    private ?int $numberOfReviews = null;
    private ?int $numberOfRatings = null;
    private ?string $type = null;
    private ?object $sentiments = null;

    /**
     * @return string|null
     */
    public function getHotelId(): ?string
    {
        return $this->hotelId;
    }

    /**
     * @return int|null
     */
    public function getOverallRating(): ?int
    {
        return $this->overallRating;
    }

    /**
     * @return int|null
     */
    public function getNumberOfReviews(): ?int
    {
        return $this->numberOfReviews;
    }

    /**
     * @return int|null
     */
    public function getNumberOfRatings(): ?int
    {
        return $this->numberOfRatings;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return HotelSentimentDetails|null
     */
    public function getSentiments(): ?object
    {
        return Resource::toResourceObject(
            $this->sentiments,
            HotelSentimentDetails::class
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
