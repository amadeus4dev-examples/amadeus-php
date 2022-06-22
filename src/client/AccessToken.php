<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Constants;

/**
 * A memoized Access Token, with the ability to auto-refresh when needed.
 * @hide as only used internally
 */
class AccessToken
{
    private ?string $access_token = null;
    private ?int $expires_at = null;
    private string $cachedTokenFile;

    private HTTPClient $client;

    /**
     * @param HTTPClient $client
     * @param string $cachedTokenFile
     */
    public function __construct(HTTPClient $client, string $cachedTokenFile = __DIR__ . '/cached_token.json')
    {
        $this->client = $client;
        $this->cachedTokenFile = $cachedTokenFile;

        if (!file_exists($cachedTokenFile)) {
            $this->resetCachedToken();
        }

        $this->readCachedToken($cachedTokenFile);
    }

    /**
     * @return void
     */
    public function updateAccessToken(): void
    {
        // Checks if it is the first time to fetch access token
        if ($this->access_token != null) {
            // Checks if the current access token expires.
            if ($this->expires_at < time()) {
                // If expired then refresh the token
                $this->storeAccessToken($this->fetchAccessToken());

                file_put_contents(
                    'php://stdout',
                    "Access token expired ! Automatically update access token -> [". $this->access_token ."] !"."\n"
                );
            } else {
                // Else still return the current token

                file_put_contents(
                    'php://stdout',
                    "Current access token -> [". $this->access_token ."] is still available !"."\n"
                );
            }
        } else {
            // First time to fetch access token
            $this->storeAccessToken($this->fetchAccessToken());

            file_put_contents(
                'php://stdout',
                "First time to fetch access token -> [". $this->access_token ."] !"."\n"
            );
        }
    }

    private function storeAccessToken(object $object)
    {
        $this->access_token = $object->access_token;

        // Renew the token 10 seconds earlier than required
        // Cuz the token will expire in 1799 seconds
        $this->expires_at = time() + $object->expires_in - 10;

        $newCachedToken = (object) [
            "access_token" => $this->access_token,
            "expires_at" => $this->expires_at
        ];
        file_put_contents($this->cachedTokenFile, json_encode($newCachedToken));
    }

    /**
     * @return object|null
     */
    public function fetchAccessToken(): ?object
    {
        $params = array(
            'client_id' => $this->client->getConfiguration()->getClientId(),
            'client_secret' => $this->client->getConfiguration()->getClientSecret(),
            'grant_type' => 'client_credentials'
        );

        $request = new Request(
            Constants::POST,
            '/v1/security/oauth2/token',
            $params,
            null,
            null,
            $this->client
        );

        $response = $this->client->execute($request);

        return $response->getBodyAsJsonObject();
    }

    /**
     * @return string|null
     */
    public function getBearerToken(): ?string
    {
        $this->updateAccessToken();
        return $this->access_token;
    }

    /**
     * @return int|null
     */
    public function getExpiresAt(): ?int
    {
        return $this->expires_at;
    }

    /**
     * @param string $filename
     * @return void
     */
    private function readCachedToken(string $filename): void
    {
        $file = fopen($filename, 'r');
        $fileSize = filesize($filename);
        $fileContent = fread($file, $fileSize);
        fclose($file);

        $cachedToken = json_decode($fileContent, true);
        if ($cachedToken["access_token"] != null) {
            $this->access_token = $cachedToken['access_token'];
        }
        if ($cachedToken["expires_at"] != null) {
            $this->expires_at = $cachedToken['expires_at'];
        }
    }

    /**
     * @return void
     */
    public function resetCachedToken(): void
    {
        file_put_contents(
            $this->cachedTokenFile,
            '{"access_token":null,"expires_at":null}'
        );
    }
}
