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
                                    intro
                                    slug
                                    body {
                                        json
                                    }
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
        return Inertia::render('index', [
            "header" => $data["header"],
            "body" => $data["body"],
            "footer" => $data["footer"]
        ]);
    }

    public function show($slug)
    {
        $spaceID = env('CONTENTFUL_SPACE_ID');
        $accessToken = env('CONTENTFUL_DELIVERY_TOKEN');
        $environment = env('CONTENTFUL_ENVIRONMENT_ID');

        $endpoint = "https://graphql.contentful.com/content/v1/spaces/" . $spaceID . "/environments/" . $environment;

        $articleQuery = <<<GQL
        query {
            articleCollection (where: {slug: "$slug"},limit:1){
                items{
                    title
                    slug
                    intro
                    body{
                        json
                    }
                    image{
                        asset{
                            url
                        }
                    }
                }
            }
        }
        GQL;


        $articleResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => sprintf("Bearer %s", $accessToken)
        ])->post($endpoint, [
            'query' => $articleQuery
        ])->json();
         
        $layout = <<<GQL
        query {
            layoutCollection(where:{title: "Child Layout"}, limit:1){
                items{
                header{
                    title
                    pageTitle
                    hero{
                    title
                        asset{
                            url
                        }
                    }
                    }
                footer{
                    title
                    text
                    }
                }
            }
        }
        GQL;


        $layoutResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => sprintf("Bearer %s", $accessToken)
        ])->post($endpoint, [
            'query' => $layout
        ])->json();
        $data = ["header" => $layoutResponse["data"]["layoutCollection"]["items"][0]["header"],
                "footer" => $layoutResponse["data"]["layoutCollection"]["items"][0]["footer"],
                "body" => $articleResponse["data"]["articleCollection"]["items"][0]];
        
        return Inertia::render('show', $data);
    }

}
