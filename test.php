<?php declare(strict_types=1);

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;

require __DIR__ . '/vendor/autoload.php'; // include composer autoloader

try {
    $amadeus = Amadeus::builder("Y0v5D4pbkijUvoNjLozwzJqTph8lr4CR", "5544MxgSurVZIOtx")
        ->setSsl(true)
        ->build();

    $recommendloc = $amadeus->getReferenceData()->getRecommendedLocations()->get(["cityCodes"=>"PAR", "travelerCountryCode"=>"FR"]);
    print $recommendloc[0];
} catch (ResponseException $e) {
    print $e;
}