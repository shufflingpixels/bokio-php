<?php

namespace Shufflingpixels\BokioApi;

use GuzzleHttp\Client as GuzzleClient;
use Shufflingpixels\BokioApi\Api\CustomerResource;
use Shufflingpixels\BokioApi\Api\JournalResource;

class Api
{
    protected Client $client;

    public function __construct(Auth $auth)
    {
        $httpClient = new GuzzleClient([
            'base_uri' => 'https://api.bokio.se'
        ]);

        $this->client = new Client($httpClient, $auth);
    }

    public function customer() : CustomerResource
    {
        return new CustomerResource($this->client);
    }

    public function journal() : JournalResource
    {
        return new JournalResource($this->client);
    }
}
