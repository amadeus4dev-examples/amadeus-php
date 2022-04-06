<?php declare(strict_types=1);

namespace Amadeus;

class Constants
{
    // HTTP verbs
    const GET = "GET";
    const POST = "POST";

    // APIs which need an X-HTTP-Method-Override GET HEADER
    const API_NEED_EXTRA_HEADER = array(
        "/v1/shopping/availability/flight-availabilities"
    );

    const HTTPS = "https";
    const HTTP = "http";

    const ACCEPT = "Accept: ";
    const AUTHORIZATION = "Authorization: ";
    const CONTENT_TYPE = "Content-Type: ";
    const X_HTTP_METHOD_OVERRIDE = "X-HTTP-Method-Override: ";
    const BEARER = "Bearer ";

}