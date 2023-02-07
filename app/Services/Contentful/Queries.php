<?php

namespace App\Services\Contentful;

class Queries
{
    const HOME = <<<GQL
    query{
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
}
