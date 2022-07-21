<?php

declare(strict_types=1);

namespace Amadeus;

class Constants
{
    // HTTP verbs
    public const GET = "GET";
    public const POST = "POST";

    // APIs which need an X-HTTP-Method-Override GET HEADER
    public const API_NEED_EXTRA_HEADER = array(
        '/v2/shopping/flight-offers',
        '/v1/shopping/seatmaps',
        '/v1/shopping/availability/flight-availabilities',
        '/v2/shopping/flight-offers/prediction',
        '/v1/shopping/flight-offers/pricing',
        '/v1/shopping/flight-offers/upselling'
    );

    public const HTTPS = "https";
    public const HTTP = "http";

    public const ACCEPT = "Accept: ";
    public const AUTHORIZATION = "Authorization: ";
    public const CONTENT_TYPE = "Content-Type: ";
    public const X_HTTP_METHOD_OVERRIDE = "X-HTTP-Method-Override: ";
    public const BEARER = "Bearer ";
}
