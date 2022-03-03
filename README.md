# Amadeus PHP SDK

## Intro
This SDK is still in developing, which has not been published to Composer. 
But you can clone this repo just for fun :)

And remember before coding your need to install the dependencies,
which you just need to run the following in terminal
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

require './vendor/autoload.php';

$amadeus = new Amadeus(
    "REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET"
);

try
{
    $destinations = $amadeus->airport->directDestinations->get(
        array(
            "departureAirportCode" => "MAD",
            "max" => 2
        )
    );

    print_r($destinations);

} 
catch (Exception $e) 
{
    print_r($e);

}
```