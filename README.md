# Amadeus PHP SDK

## Intro
This SDK is still in developing, which has not been published to Composer. 
But you can clone this repo just for fun :)

And remember before coding you should install all the dependencies,
which just need to run the following command in terminal

- if you directly clone this repo
```
composer install
```
- if you want to use it as your libraries

``` 
composer require xianqiliu/amadeus-php:dev-master
```

## Getting Started

To make your first API call you will need to [register for an Amadeus
Developer Account](https://developers.amadeus.com/create-account) and set up
your first application.

```PHP 
<?php

use Amadeus\Amadeus;

// include composer autoloader
require __DIR__ . '/vendor/autoload.php';

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

    print($destinations[0]);

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

    print($flightAvailabilities[0]);

    // Make arbitrary call
    $destinations = $amadeus->get(
        '/v1/airport/direct-destinations',
        array(
            "departureAirportCode" => "MAD",
            "max" => 2
        )
    );

    print($destinations);

} 
catch (Exception $e) 
{
    print_r($e);
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
$amadeus->setSslCertificate($REPLACE_BY_YOUR_SSL_CERT_PATH);
```

## Error Log
The SDK includes [error_log](https://www.php.net/manual/en/function.error-log.php) function, which makes it easier locate the error produced in this SDK.

Error Message can be sent to PHP's system logger, using the Operating System's system logging mechanism or a file, depending on what the [error_log](https://www.php.net/manual/en/errorfunc.configuration.php#ini.error-log) configuration directive is set to. This is the default option.
```PHP
$amadeus = Amadeus
    ::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
    ->setLogger()
    ->build();
```

Alternatively, Error Message can be appended to the file destination.
```PHP
$amadeus = Amadeus
    ::builder("REPLACE_BY_YOUR_API_KEY", "REPLACE_BY_YOUR_API_SECRET")
    ->setLogger("REPLACE_BY_YOUR_CUSTOM_LOG_FILE_PATH")
    ->build();
```