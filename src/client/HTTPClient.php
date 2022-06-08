<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Configuration;

interface HTTPClient
{
    public function execute(Request $request): Response;
    public function getWithArrayParams(string $path, array $query): Response;
    public function postWithStringBody(string $path, string $body): Response;
    public function getAccessToken(): ?AccessToken;
    public function getConfiguration(): Configuration;
    public function getSSLCertificate(): ?string;
    public function setSSLCertificate(string $filePath): void;
}
