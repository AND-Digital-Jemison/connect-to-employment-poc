<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
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

        $query = new \Contentful\Delivery\Query();
        $query->setContentType('pageSection')->where('fields.' . "title", "Articles")->setInclude(6);


        $entries = $this->client->getEntries($query);
        $header = $entries[0]->get('header');
        $body = $entries[0]->get('body');
        $footer = $entries[0]->get('footer');


        return Inertia::render('index', [
            'header' => ['pageTitle' => $header->pageTitle, 'hero' => $header->get('hero')],
            'body' => ['introText' => $body->introText, 'articles' => $body->get('articleListItems')],
            'footer' => ['footerText' => $footer->text]

        ]);
    }

    public function show()
    {
        return Inertia::render('show');
    }
}