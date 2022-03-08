<?php declare(strict_types=1);

namespace Amadeus;

class Options
{
    /**
     * @param array $params
     * @param string $bearerToken
     * @return array
     */
    public static function optionsParams4GET(array $params, string $bearerToken): array
    {
        $options['headers'] = self::prepareHeaders($bearerToken);
        $options['query'] = $params;
        return $options;
    }

    /**
     * @param string $body
     * @param string $bearerToken
     * @return array
     */
    public static function optionsBody4POST(string $body, string $bearerToken): array
    {
        $options['headers'] = self::prepareHeaders($bearerToken);
        $options['body'] = $body;
        return $options;
    }

    /**
     * @param $bearerToken
     * @return array
     */
    private static function prepareHeaders($bearerToken): array
    {
        $headers['Accept'] = 'application/json, application/vnd.amadeus+json';
        $headers['Authorization'] = 'Bearer ' . $bearerToken;
        $headers['Content-Type'] = 'application/vnd.amadeus+json';
        return $headers;
    }
}