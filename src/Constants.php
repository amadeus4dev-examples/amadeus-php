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
        "/v1/shopping/availability/flight-availabilities"
    );

    public const HTTPS = "https";
    public const HTTP = "http";

    public const ACCEPT = "Accept: ";
    public const AUTHORIZATION = "Authorization: ";
    public const CONTENT_TYPE = "Content-Type: ";
    public const X_HTTP_METHOD_OVERRIDE = "X-HTTP-Method-Override: ";
    public const BEARER = "Bearer ";
}
