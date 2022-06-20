<?php

declare(strict_types=1);

namespace Amadeus\Resources;

class FlightBookingRequirements implements ResourceInterface
{
    private ?bool $invoiceAddressRequired = null;
    private ?bool $mailingAddressRequired = null;
    private ?bool $emailAddressRequired = null;
    private ?bool $phoneCountryCodeRequired = null;
    private ?bool $mobilePhoneNumberRequired = null;
    private ?bool $phoneNumberRequired = null;
    private ?bool $postalCodeRequired = null;
    private ?array $travelerRequirements = null;

    /**
     * @return bool|null
     */
    public function getInvoiceAddressRequired(): ?bool
    {
        return $this->invoiceAddressRequired;
    }

    /**
     * @return bool|null
     */
    public function getMailingAddressRequired(): ?bool
    {
        return $this->mailingAddressRequired;
    }

    /**
     * @return bool|null
     */
    public function getEmailAddressRequired(): ?bool
    {
        return $this->emailAddressRequired;
    }

    /**
     * @return bool|null
     */
    public function getPhoneCountryCodeRequired(): ?bool
    {
        return $this->phoneCountryCodeRequired;
    }

    /**
     * @return bool|null
     */
    public function getMobilePhoneNumberRequired(): ?bool
    {
        return $this->mobilePhoneNumberRequired;
    }

    /**
     * @return bool|null
     */
    public function getPhoneNumberRequired(): ?bool
    {
        return $this->phoneNumberRequired;
    }

    /**
     * @return bool|null
     */
    public function getPostalCodeRequired(): ?bool
    {
        return $this->postalCodeRequired;
    }

    /**
     * @return PassengerConditions[]|null
     */
    public function getTravelerRequirements(): ?array
    {
        return Resource::toResourceArray(
            $this->travelerRequirements,
            PassengerConditions::class
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
