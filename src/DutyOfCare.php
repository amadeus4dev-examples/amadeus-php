<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\DutyOfCare\Diseases;

/**
 * A namespaced client for the
 * "/dutyOfCare" endpoints.
 *
 * Access via the Amadeus client object.
 *
 *      $amadeus = Amadeus::builder("clientId", "secret")->build();
 *      $amadeus->getDutyOfCare();
 *
 */
class DutyOfCare
{
    /**
     * A namespaced client for the
     * "/v1/duty-of-care/diseases" endpoints.
     */
    private Diseases $diseases;

    /**
     * Constructor
     * @param Amadeus $amadeus
     */
    public function __construct(Amadeus $amadeus)
    {
        $this->diseases = new Diseases($amadeus);
    }

    /**
     * Get a namespaced client for the
     * "/v1/duty-of-care/diseases" endpoints.
     * @return Diseases
     */
    public function getDiseases(): Diseases
    {
        return $this->diseases;
    }
}
