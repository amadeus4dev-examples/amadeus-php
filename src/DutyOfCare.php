<?php

declare(strict_types=1);

namespace Amadeus;

use Amadeus\DutyOfCare\Diseases;

/**
 * <p>
 *   A namespaced client for the
 *   <code>/dutyOfCare</code> endpoints.
 * </p>
 *
 * <p>
 *   Access via the Amadeus client object.
 * </p>
 *
 * <code>
 *  $amadeus = Amadeus::builder("clientId", "secret")->build();
 *  $amadeus->getDutyOfCare();
 * </code>
 */
class DutyOfCare
{
    /**
     * <p>
     *   A namespaced client for the
     *   <code>/v1/duty-of-care/diseases</code> endpoints.
     * </p>
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
     * <p>
     *   A namespaced client for the
     *   <code>/v1/duty-of-care/diseases</code> endpoints.
     * </p>
     * @return Diseases
     */
    public function getDiseases(): Diseases
    {
        return $this->diseases;
    }
}
