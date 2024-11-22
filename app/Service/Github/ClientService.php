<?php

namespace App\Service\Github;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ClientService
{

    private string $baseUri = 'https://api.github.com';

    public function getClient(): PendingRequest
    {
        return Http::withOptions([
            'base_uri' => $this->baseUri
        ])
            ->withHeaders([
                'Accept' => 'application/vnd.github+json',
                'X-GitHub-Api-Version' => '2022-11-28'
            ])
            ->withToken(config('services.github.personal_access_token'));
    }
}
