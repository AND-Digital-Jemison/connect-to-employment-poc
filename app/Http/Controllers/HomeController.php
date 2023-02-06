<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Contentful\Delivery\Client;

class HomeController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function index()
    {
        $spaceID = env('CONTENTFUL_SPACE_ID');
        $accessToken = env('CONTENTFUL_DELIVERY_TOKEN');
        $environment = env('CONTENTFUL_ENVIRONMENT_ID');

        $endpoint = "https://graphql.contentful.com/content/v1/spaces/".$spaceID."/environments/".$environment;

        $query = <<<GQL
        query {
            pageSection(id: "pageSection") {
                title
            }
        }
        GQL;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => sprintf("Bearer %s",$accessToken)
        ])->post($endpoint, [
            'query' => $query
        ]);


        dump($response->json());


    }

    public function show()
    {
        return Inertia::render('show');
    }
}
