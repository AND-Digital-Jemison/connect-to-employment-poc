<?php

namespace App\Services;

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

    public function getFunction()
    {
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
        return $this->client->post($this->endpoint, [
            'query' => $query
        ])->json();
    }
}
