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
        $entries = $this->client->getContents('page');
        dd($entries);


        return Inertia::render('index');
    }

    public function show()
    {
        return Inertia::render('show');
    }
}
