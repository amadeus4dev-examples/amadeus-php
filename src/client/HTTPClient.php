<?php

declare(strict_types=1);

namespace Amadeus\Client;

use Amadeus\Configuration;

interface HTTPClient
{
    public function execute(Request $request): Response;
    public function getWithOnlyPath(string $path): Response;
    public function getWithArrayParams(string $path, array $params): Response;
    public function postWithStringBody(string $path, string $body, ?array $params = null): Response;
    public function getAccessToken(): ?AccessToken;
    public function getConfiguration(): Configuration;
    public function getSSLCertificate(): ?string;
    public function setSSLCertificate(string $filePath): void;
}
