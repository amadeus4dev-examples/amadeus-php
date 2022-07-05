<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Configuration;
use Amadeus\Constants;
use Amadeus\Exceptions\AuthenticationException;
use Amadeus\Exceptions\ClientException;
use Amadeus\Exceptions\NetworkException;
use Amadeus\Exceptions\NotFoundException;
use Amadeus\Exceptions\ResponseException;
use Amadeus\Exceptions\ServerException;

/**
 * The HTTP part of the Amadeus API client.
 */
class BasicHTTPClient implements HTTPClient
{
    // A cached copy of the Access Token. It will auto refresh for every bearerToken (if needed)
    protected ?AccessToken $accessToken = null;

    /**
     * The configuration for this API client.
     */
    private Configuration $configuration;

    /**
     * The ssl certificate for this API client.
     */
    private ?string $sslCertificate = null;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->accessToken = new AccessToken($this);
    }

    /**
     * <p>
     *   A helper module for making generic getWithOnlyPath requests calls.It is used by
     *   every namespaced API getWithOnlyPath method.
     * </p>
     *
     * <pre>
     *  $amadeus->getShopping()->getHotelOffer()->get("XXX");
     * </pre>
     *
     * <p>
     *   It can be used to make any generic API call that is automatically
     *   authenticated using your API credentials:
     * </p>
     *
     * <pre>
     *  $this->amadeus->getClient()->getWithOnlyPath("/v3/shopping/hotel-offers"."/"."XXX");
     * </pre>
     *
     * @param string $path
     * @return Response
     * @throws ResponseException
     */
    public function getWithOnlyPath(string $path): Response
    {
        $request = new Request(
            Constants::GET,
            $path,
            null,
            null,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * <p>
     *   A helper module for making generic getWithArrayParams requests calls.It is used by
     *   every namespaced API getWithArrayParams method.
     * </p>
     *
     * <pre>
     *  $amadeus->getAirport()->getDirectDestinations()->get(
     *      ["departureAirportCode" => "MAD", "max" => 2]
     *  );
     * </pre>
     *
     * <p>
     *   It can be used to make any generic API call that is automatically
     *   authenticated using your API credentials:
     * </p>
     *
     * <pre>
     *  $this->amadeus->getClient()->getWithArrayParams(
     *      '/v1/airport/direct-destinations',
     *      ["departureAirportCode" => "MAD", "max" => 2]
     *  );
     * </pre>
     *
     * @param string $path
     * @param array $params
     * @return Response
     * @throws ResponseException
     */
    public function getWithArrayParams(string $path, array $params): Response
    {
        $request = new Request(
            Constants::GET,
            $path,
            $params,
            null,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * <p>
     *   A helper module for making generic postWithStringBody requests calls.It is used by
     *   every namespaced API postWithStringBody method.
     * </p>
     *
     * <pre>
     *  $flightOffers = $amadeus->getShopping()->getFlightOffers()->post($body);
     * </pre>
     *
     * <p>
     *   It can be used to make any generic API call that is automatically
     *   authenticated using your API credentials:
     * </p>
     *
     * <pre>
     *  $amadeus->getClient()->postWithStringBody(
     *      '/v2/shopping/flight-offers',
     *      $body
     *  );
     * </pre>
     *
     * @param string $path
     * @param string $body
     * @param array|null $params
     * @return Response
     * @throws ResponseException
     */
    public function postWithStringBody(string $path, string $body, ?array $params = null): Response
    {
        $request = new Request(
            Constants::POST,
            $path,
            $params,
            $body,
            $this->getAccessToken()->getBearerToken(),
            $this
        );

        return $this->execute($request);
    }

    /**
     * Execute HTTP Request using PHP-cURL extension
     *
     * @param Request $request
     * @return Response
     * @throws ResponseException
     */
    public function execute(Request $request): Response
    {
        $curlHandle = curl_init();
        $this->setCurlOptions($curlHandle, $request);
        $result = curl_exec($curlHandle);
        if (!$result) {
            $result = null;
        }
        $info = curl_getinfo($curlHandle);
        curl_close($curlHandle);

        $response = new Response($request, $info, $result);
        $this->detectError($response);

        return $response;
    }

    /**
     * Detect error based on the returned status code
     *
     * @param Response $response
     * @return void
     * @throws ResponseException
     */
    protected function detectError(Response $response): void
    {
        $exception = null;
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 500) {
            $exception = new ServerException($response);
        } elseif ($statusCode == 404) {
            $exception = new NotFoundException($response);
        } elseif ($statusCode == 401) {
            $exception = new AuthenticationException($response);
        } elseif ($statusCode == 400) {
            $exception = new ClientException($response);
        } elseif ($statusCode == 0) {
            $exception = new NetworkException($response);
        } elseif ($statusCode == 204) {
            return; // 204 No content
        } elseif ($statusCode == 201) {
            return; // 201 A resource created successfully
        } elseif ($statusCode != 200) {
            $exception = new ResponseException($response);
        }

        if ($exception != null) {

            // Log the error to file
            error_log($exception->__toString());

            // Log the error to console
            file_put_contents(
                'php://stdout',
                $exception->__toString()
            );

            throw $exception;
        }
    }

    /**
     * Set curl options
     *
     * @param mixed $curlHandle
     * @param Request $request
     * @return void
     */
    private function setCurlOptions($curlHandle, Request $request): void
    {
        // Url
        curl_setopt($curlHandle, CURLOPT_URL, $request->getUri());

        // Header
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $request->getHeaders());

        // Transfer the return to string
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        // Include the header in the output
        curl_setopt($curlHandle, CURLOPT_HEADER, true);

        // Set Timeout
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, $this->getConfiguration()->getTimeout());

        if ($request->getSslCertificate() != null) {
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curlHandle, CURLOPT_CAINFO, $request->getSslCertificate());
        } else {
            //for debug only!
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        }

        if ($request->getVerb() == Constants::POST) {
            curl_setopt($curlHandle, CURLOPT_POST, true);
            if ($request->getBody() != null) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $request->getBody());
            } elseif ($request->getParams() != null) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($request->getParams()));
            }
        }
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return string|null
     */
    public function getSSLCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function setSSLCertificate(string $filePath): void
    {
        $this->sslCertificate = $filePath;
    }
}
