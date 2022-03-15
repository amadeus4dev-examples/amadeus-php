# Amadeus PHP SDK

## Intro
This SDK is still in developing, which has not been published to Composer. 
But you can clone this repo just for fun :)

And remember before coding you should install all the dependencies,
which just need to run the following command in terminal
``` 
composer install
```

## Getting Started

To make your first API call you will need to [register for an Amadeus
Developer Account](https://developers.amadeus.com/create-account) and set up
your first application.

```PHP 
<?php

use Amadeus\Amadeus;
use Exception;

require './vendor/autoload.php';

try
{
    $amadeus = Amadeus
        ::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
        ->build();

    // Airport Route API GET
    $destinations = $amadeus->airport->directDestinations->get(
        array(
            "departureAirportCode" => "MAD",
            "max" => 2
        )
    );

    print_r($destinations[0]);

    // Flight Availabilities Search API POST
    $body =
        '{
        "originDestinations": [
            {
                "id": "1",
                "originLocationCode": "BOS",
                "destinationLocationCode": "MAD",
                "departureDateTime": {
                "date": "2022-04-01",
                    "time": "21:15:00"
                }
            }
        ],
        "travelers": [
            {
                "id": "1",
                "travelerType": "ADULT"
            },
            {
                "id": "2",
                "travelerType": "CHILD"
            }
        ],
        "sources": [
            "GDS"
        ]
    }';

    $flightAvailabilities =
        $amadeus->shopping->availability->flightAvailabilities->post($body);

    print_r($flightAvailabilities[0]);

    // Make arbitrary call
    $destinations = $amadeus->get(
        '/v1/airport/direct-destinations',
        array(
            "departureAirportCode" => "MAD",
            "max" => 2
        )
    );

    print_r($destinations->getResult()->{'data'});

} 
catch (Exception $e) 
{
    print_r($e);
}
```
