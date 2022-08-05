# Changelog
## 0.3.0 - 2022-08-05

Add support for the [Travel Recommendations API](https://developers.amadeus.com/self-service/category/trip/api-doc/travel-recommendations/api-reference)

Add support for the [Airport On-Time Performance API](https://developers.amadeus.com/self-service/category/air/api-doc/airport-on-time-performance/api-reference)

Fix security vulnerabilities and reduce code smells based on the analysis result from Sonar Cloud.

Fix and improve documents including README.md, CONTRIBUTING.md, and composer.json.

Standardize code comments.

Generate [Amadeus PHP SDK Docs](https://github.com/amadeus4dev/amadeus-php)

## 0.2.0 - 2022-07-21

Add support for the [Flight Cheapest Dates Search API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-cheapest-date-search/api-reference)

Add support for the [Airline Code Lookup API](https://developers.amadeus.com/self-service/category/air/api-doc/airline-code-lookup/api-reference)

Add support for the [On-Demand Flight Status API](https://developers.amadeus.com/self-service/category/air/api-doc/on-demand-flight-status/api-reference)

Add support for the [Airport Nearest Relevant API](https://developers.amadeus.com/self-service/category/air/api-doc/airport-nearest-relevant/api-reference)

Add support for the [Flight Delay Prediction API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-delay-prediction/api-reference)

Add support for the [Travel Restrictions API](https://developers.amadeus.com/self-service/category/covid-19-and-travel-safety/api-doc/travel-restrictions/api-reference)

Add support for the [Tour and Activities API](https://developers.amadeus.com/self-service/category/destination-content/api-doc/tours-and-activities/api-reference)

Add support for the [Flight Inspiration Search API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-inspiration-search/api-reference)

Add support for the [Hotel Ratings API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-ratings/api-reference)

Add support for the [Flight Choice Prediction API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-choice-prediction/api-reference)

Add support for the endpoint ```/reference-data/locations/{locationId}``` in the [Airport & City Search API](https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference)

Modify the way of calling ```/shopping/hotel-offers/{offerId}``` to ```$amadeus->getShopping().getHotelOffer("XXX")->get()``` in the [Hotel Search API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference)

Add support for initializing without variables, which supports ```Amadeus::builder()->build()``` if the environment variables ``AMADEUS_CLIENT_ID`` and ``AMADEUS_CLIENT_SECRET`` are present.

Add minimum logging & debugging feature, which supports to log ```AccessToken/Request/Response/ResponseException``` in the ```debug``` level.

Improve Test Line Coverage until 85%.

## 0.1.1 - 2022-06-30

No update, the purpose of releasing this version is to test the release process. 


## 0.1.0 - 2022-06-29

The 0.1.0 version of the Amadeus for Developers PHP SDK:

Add support for the [Flight Offers Search API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference)

Add support for the [Flight Offers Price API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference)

Add support for the [Flight Create Orders API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-create-orders/api-reference)

Add support for the [Airport & City Search API](https://developers.amadeus.com/self-service/category/air/api-doc/airport-and-city-search/api-reference)

Add support for the [Hotel Name Autocomplete API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-name-autocomplete/api-reference)

Add support for the [Hotel List API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-list/api-reference)

Add support for the [Hotel Search API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-search/api-reference)

Add support for the [Hotel Booking API](https://developers.amadeus.com/self-service/category/hotel/api-doc/hotel-booking/api-reference)

Add support for the [Flight Availabilities Search API](https://developers.amadeus.com/self-service/category/air/api-doc/flight-availabilities-search/api-reference)

Add support for the [Airport Routes API](https://developers.amadeus.com/self-service/category/air/api-doc/airport-routes/api-reference)

