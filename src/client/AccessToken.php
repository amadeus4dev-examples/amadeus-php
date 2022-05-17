<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Amadeus;
use Amadeus\Constants;
use Amadeus\Exceptions\ResponseException;
use Amadeus\HTTPClient;
use Amadeus\Request;

class AccessToken
{
    private ?string $type = null;
    private ?string $username = null;
    private ?string $application_name = null;
    private ?string $client_id = null;
    private ?string $token_type = null;
    private ?string $access_token = null;
    private ?int $expires_in = null;
    private ?string $state = null;
    private ?string $scope = null;
    private int $expires_at;

    private HTTPClient $client;

    /**
     * @param HTTPClient $client
     */
    public function __construct(HTTPClient $client)
    {
        $this->client = $client;

        // Renew the token 10 seconds earlier than required
        // Cuz the token will expire in 1799 seconds
        $this->expires_at = time()+20;
    }

    /**
     * @throws ResponseException
     */
    public function updateAccessToken(): void
    {
        // Checks if it is the first time to fetch access token
        if ($this->access_token != null) {
            // Checks if the current access token expires.
            if ($this->expires_at < time()) {
                // If expired then refresh the token
                $this->constructToken($this->fetchAccessToken());

                file_put_contents(
                    'php://stdout',
                    "Access Token Expired!"."\n"
                    ."Automatically Update Access Token!".$this->access_token."\n"
                );

                // Else still return the current token
            }
        } else {
            // First time to fetch access token
            $this->constructToken($this->fetchAccessToken());

            file_put_contents(
                'php://stdout',
                "First time to fetch AccessToken!".$this->access_token."\n"
            );
        }
    }

    /**
     * @throws ResponseException
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

    protected function constructToken(object $object)
    {
        foreach ($object as $key =>  $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getApplicationName(): ?string
    {
        return $this->application_name;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @return string|null
     */
    public function getTokenType(): ?string
    {
        return $this->token_type;
    }

    /**
     * @return string|null
     * @throws ResponseException
     */
    public function getAccessToken(): ?string
    {
        $this->updateAccessToken();
        return $this->access_token;
    }

    /**
     * @return int|null
     */
    public function getExpiresIn(): ?int
    {
        return $this->expires_in;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expires_at;
    }
}
