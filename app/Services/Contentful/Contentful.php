<?php

namespace App\Services\Contentful;

use Illuminate\Support\Facades\Http;


class Contentful
{
    private $client;
    private $endpoint;
    public function __construct()
    {
        $spaceID = env('CONTENTFUL_SPACE_ID');
        $accessToken = env('CONTENTFUL_DELIVERY_TOKEN');
        $environment = env('CONTENTFUL_ENVIRONMENT_ID');
        $this->endpoint = "https://graphql.contentful.com/content/v1/spaces/" . $spaceID . "/environments/" . $environment;
        $this->client = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => sprintf("Bearer %s", $accessToken)
        ]);
    }

    public function getFunction($query)
    {
        return $this->client->post($this->endpoint, [
            'query' => $query
        ])->json();
    }
}
