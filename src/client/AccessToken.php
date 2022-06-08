<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Constants;

class AccessToken
{
    private ?string $access_token = null;
    private ?int $expires_in = null;
    //private ?int $expires_at = null;

    private HTTPClient $client;

    /**
     * @param HTTPClient $client
     */
    public function __construct(HTTPClient $client)
    {
        $this->client = $client;
    }

//    public function updateAccessToken(): void
//    {
//        // Checks if it is the first time to fetch access token
//        if ($this->access_token != null) {
//            // Checks if the current access token expires.
//            if ($this->expires_at < time()) {
//                // If expired then refresh the token
//                $this->storeAccessToken($this->fetchAccessToken());
//
//                file_put_contents(
//                    'php://stdout',
//                    "Access token expired ! Automatically update access token -> [". $this->access_token ."] !"."\n"
//                );
//            } else {
//                // Else still return the current token
//
//                file_put_contents(
//                    'php://stdout',
//                    "Current access token -> [". $this->access_token ."] is still available !"."\n"
//                );
//            }
//        } else {
//            // First time to fetch access token
//            $this->storeAccessToken($this->fetchAccessToken());
//
//            file_put_contents(
//                'php://stdout',
//                "First time to fetch access token -> [". $this->access_token ."] !"."\n"
//            );
//        }
//    }

    public function updateAccessToken(): void
    {
        if ($this->access_token == null) {
            $this->storeAccessToken($this->fetchAccessToken());
        }
    }

    protected function storeAccessToken(object $object)
    {
        $this->access_token = $object->access_token;
        $this->expires_in = $object->expires_in;

        // Renew the token 10 seconds earlier than required
        // Cuz the token will expire in 1799 seconds
        //$this->expires_at = time() + $object->expires_in - 10;
    }

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
     * @param string|null $access_token
     */
    public function setBearerToken(?string $access_token): void
    {
        $this->access_token = $access_token;
    }

    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

//    /**
//     * @param int|null $expires_at
//     */
//    public function setExpiresAt(?int $expires_at): void
//    {
//        $this->expires_at = $expires_at;
//    }
//
//    /**
//     * @return int
//     */
//    public function getExpiresAt(): int
//    {
//        return $this->expires_at;
//    }
}
