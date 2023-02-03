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
        $query->setContentType('page');

        $entries = $this->client->getEntries($query);

        return Inertia::render('index',[
            'entries' => $entries
        ]);
    }

    public function show()
    {
        return Inertia::render('show');
    }
}
