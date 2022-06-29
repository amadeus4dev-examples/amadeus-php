# Amadeus PHP SDK

[![Discord](https://img.shields.io/discord/696822960023011329?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/cVrFBqx)

Amadeus provides a rich set of APIs for the travel industry. For more details, check out the [Amadeus for Developers Portal](https://developers.amadeus.com).

## Installation

This library requires PHP 7.4+. You can install the SDK via Composer

``` 
composer require amadeus4dev/amadeus-php:0.1.0
```

## Getting Started

To make your first API call you will need to [register for an Amadeus
Developer Account](https://developers.amadeus.com/create-account) and set up
your first application.

```PHP 
<?php declare(strict_types=1);

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;

require __DIR__ . '/vendor/autoload.php'; // include composer autoloader

try {
    $amadeus = Amadeus::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
        ->setSsl(true)
        ->build();

    // Flight Offers Search GET
    $flightOffers = $amadeus->getShopping()->getFlightOffers()->get(
                        array(
                            "originLocationCode" => "PAR",
                            "destinationLocationCode" => "MAD",
                            "departureDate" => "2022-12-29",
                            "adults" => 1
                        )
                    );
    print $flightOffers[0];

    // Flight Offers Search POST
    $body ='{
              "originDestinations": [
                {
                  "id": "1",
                  "originLocationCode": "PAR",
                  "destinationLocationCode": "MAD",
                  "departureDateTimeRange": {
                    "date": "2022-12-29"
                  }
                }
              ],
              "travelers": [
                {
                  "id": "1",
                  "travelerType": "ADULT"
                }
              ],
              "sources": [
                "GDS"
              ]
            }';
    $flightOffers = $amadeus->getShopping()->getFlightOffers()->post($body);
    print $flightOffers[0];
} catch (ResponseException $e) {
    print $e;
}
```

## Initialization
The client can be initialized directly:
```PHP
//Initialize using parameters
$amadeus = Amadeus
    ::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
    ->build();
```

Your credentials can be found on the [Amadeus dashboard](https://developers.amadeus.com/my-apps).

By default, the SDK is set to `test` environment. To switch to a `production` (pay-as-you-go) environment, please switch the hostname as follows:

```PHP
//Initialize using parameters
$amadeus = Amadeus
    ::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
    ->setProductionEnvironment()
    ->build();
```

## Use SSL certificate
This library is using PHP core extension cURL for making Http Request but disabling the options for SSL verification. 
Thus it is highly suggested using a certificate with PHP’s cURL functions.

You can download the ```cacert.pem``` certificate bundle from the [official cURL website](https://curl.se/docs/caextract.html). 
Once you have downloaded the ```cacert.pem``` file, you should move it to whatever directory makes the most sense for you and your setup.

```PHP
// Set your certificate path for opening SSL verification
$amadeus->getClient()->setSslCertificate($REPLACE_BY_YOUR_SSL_CERT_PATH);
```

## Making API calls

This library conveniently maps every API path to a similar path. 

For example, `GET /v1/airport/direct-destinations?departureAirportCode=MAD` would be:

```PHP
$amadeus->getAirport()->getDirectDestinations()->get(["departureAirportCode" => "MAD"]);
```

Similarly, to select a resource by ID, you can pass in the ID to the **singular** path. 

For example,  `GET /v2/shopping/hotel-offers/XXX` would be:

```PHP
$amadeus->getShopping()->getHotelOffer()->get("XXX");
```

Additionally, You can make any arbitrary API call as well directly with the methods provided below:

```PHP
// Make a GET request only using path
$amadeus->getClient()->getWithOnlyPath("/v1/airport/direct-destinations?departureAirportCode=MAD");

// Make a GET request using path and passed parameters
$amadeus->getClient()->getWithArrayParams("/v1/airport/direct-destinations", ["departureAirportCode" => "MAD"]);

// Make a POST request using path and passed body
$amadeus->getClient()->postWithStringBody("/v1/shopping/availability/flight-availabilities", $body);
```

Keep in mind, this returns a raw `Resource`.


## Response
Every successful API call returns a ```Resource``` object. The ```Resource``` object has the raw response body (in string format) available:

```PHP
$locations = $amadeus->getReferenceData()->getLocations()->get(
                array(
                    "subType" => "CITY",
                    "keyword" => "PAR"
                )
            );

// The raw response, as a string
$locations[0]->getResponse()->getResult(); // Include response headers
$locations[0]->getResponse()->getBody(); //Without response headers

// Directly get response headers as an array
$locations[0]->getResponse()->getHeadersAsArray();

// Directly get response body as a Json Object
$locations[0]->getResponse()->getBodyAsJsonObject();

// Directly get the data part of response body
$locations[0]->getResponse()->getData();
```

## List of supported endpoints
```PHP
/* Flight Offers Search GET */
// function get(array $params) :
$amadeus->getShopping()->getFlightOffers()->get(
    array(
        "originLocationCode" => "PAR",
        "destinationLocationCode" => "MAD",
        "departureDate" => "2022-12-29",
        "adults" => 1
));

/* Flight Offers Search POST */
// function get(string $body) :
$amadeus->getShopping()->getFlightOffers()->post($body);

/* Flight Offers Price */
// function post(string $body) :
$amadeus->getShopping()->getFlightOffers()->getPricing()->post($body);
// function postWithFlightOffers(array $flightOffers, ?array $payments = null, ?array $travelers = null, ?array $params = null) : 
$flightOffers = $this->getShopping()->getFlightOffers()->get(["originLocationCode"=>"SYD", "destinationLocationCode"=>"BKK", "departureDate"=>"2022-11-01", "adults"=>1, "max"=>6]);
$amadeus->getShopping()->getFlightOffers()->getPricing()->postWithFlightOffers($flightOffers);
            
/* Flight Create Orders */
// function post(string $body) :
$amadeus->getBooking()->getFlightOrders()->post($body);
// function postWithFlightOffersAndTravelers(array $flightOffers, array $travelers);
$amadeus->getBooking()->getFlightOrders()->postWithFlightOffersAndTravelers($flightOffers, $travelers);

/* Airport and City Search (autocomplete) */
// function get(array $params) :
$amadeus->getReferenceData()->getLocations(["subType"=>"CITY,AIRPORT", "keyword"=>"MUC"]);

/* Hotel Name Autocomplete */
// function get(array $params) :
$amadeus->getReferenceData()->getLocations()->getHotel()->get(["keyword"=>"PARI", "subType"=>"HOTEL_GDS"]);

/* Hotel List */
// Get list of hotels by hotel id
// function get(array $params) :
$amadeus->getReferenceData()->getLocations()->getHotels()->getByHotels()->get(["hotelIds"=>"XXX"]);
// Get list of hotels by city code
// function get(array $params) :
$amadeus->getReferenceData()->getLocations()->getHotels()->getByCity()->get(["cityCode"=>"PAR"]);
// Get list of hotels by a GeoCode
// function get(array $params) :
$amadeus->getReferenceData()->getLocations()->getHotels()->getByGeocode()->get(["longitude"=2.160873, "latitude"=>41.397158]);

/* Hotel Search */
// Get list of available offers by hotel ids
// function get(array $params) :
$amadeus->getShopping()->getHotelOffers()->get(["hotelId" => "MCLONGHM","adults" => 1]);
// Check conditions of a specific offer
// function get(string $offerId) :
$amadeus->getShopping()->getHotelOffer()->get("xxx");

/* Hotel Booking */
// The offerId comes from the hotel offer above
// function post(string $body) :
$amadeus->getBooking()->getHotelBookings()->post($body);

/* Flight Availabilities Search */
// function post(string $body) :
$amadeus->getShopping()->getAvailability()->getFlightAvailabilities()->post($body);

/* Airport Routes */
// function get(array $params) :
$amadeus->getAirport()->getDirectDestinations()->get([["departureAirportCode" => "MAD", "max" => 2]]);
```

## Development & Contributing

Want to contribute? Read our [Contributors Guide](.github/CONTRIBUTING.md) for
guidance on installing and running this code in a development environment.


## License

This library is released under the [MIT License](LICENSE).

## Help

You can find us on [StackOverflow](https://stackoverflow.com/questions/tagged/amadeus) or join our developer community on
[Discord](https://discord.gg/cVrFBqx).