<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
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

        $endpoint = "https://graphql.contentful.com/content/v1/spaces/" . $spaceID . "/environments/" . $environment;

        $query = <<<GQL
        query {
            pageSectionCollection(where: {title: "Articles"}, limit: 1) {
                items {
                    header {
                       title
                       pageTitle
                       hero {
                        title
                        asset {
                           title
                           url
                        }
                       }
                    }
                    footer {
                        text
                    }
                    body {
                        ... on Articles {
                            title
                            articleListItemsCollection(limit:20) {
                                items {
                                    title
                                    image {
                                        asset {
                                            url
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        GQL;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => sprintf("Bearer %s", $accessToken)
        ])->post($endpoint, [
            'query' => $query
        ])->json();

        $data = $response['data']['pageSectionCollection']['items'][0];

        return Inertia::render('index',[
            "header" => $data["header"],
            "body" => $data["body"],
            "footer" => $data["footer"]
        ]);
    }

    public function show()
    {
        return Inertia::render('show');
    }
}
