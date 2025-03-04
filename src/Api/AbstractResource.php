<?php

namespace Shufflingpixels\BokioApi\Api;

use Shufflingpixels\BokioApi\Client;
use Shufflingpixels\BokioApi\Serializer\Serializer;

abstract class AbstractResource
{
    protected Client $client;

    protected Serializer $serializer;

    public function __construct(Client $client)
    {
        $this->serializer = new Serializer();
        $this->client = $client;
    }
}
