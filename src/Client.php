<?php

namespace Shufflingpixels\BokioApi;

use Shufflingpixels\BokioApi\Exception\ApiException;
use Shufflingpixels\BokioApi\Exception\EncodingException;
use Shufflingpixels\BokioApi\Objects\Error;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Client
{
    /**
     * Auth object
     */
    protected Auth $auth;

    /**
     *
     */
    protected ClientInterface $http;

    public function __construct(ClientInterface $httpClient, Auth $auth)
    {
        $this->auth = $auth;
        $this->http = $httpClient;
    }

    /**
     * @param array<mixed> $query
     */
    public function request(string $method, string $resource, array $query = [], mixed $body = null) : RequestInterface
    {
        $headers = [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => sprintf('Bearer %s', $this->auth->getToken()),
        ];

        if ($body !== null) {
            $body = json_encode($body);
            if ($body === false) {
                throw new \Exception("Failed to encode");
            }
        }

        $url = $this->url($resource, $query);

        return new Request($method, $url, $headers, $body);
    }

    /**
     * @return array<mixed>
     */
    public function send(RequestInterface $request) : array
    {
        try {
            $response = $this->http->sendRequest($request);
        } catch (ClientException $e) {
            throw new ApiException(Error::fromResponse($e->getResponse()), $e);
        }

        $body = $response->getBody()->getContents();

        if (strlen($body) < 1) {
            return [];
        }

        return json_decode($body, true) 
            ?? throw new EncodingException("Failed to decode json payload");
    }

    /**
     * @param array<mixed> $query
     */
    protected function url(string $resource, array $query = []) : string
    {
        $url = sprintf("/companies/%s", $this->auth->getId()) . $resource;
        $query = array_filter($query, fn ($query) => !is_null($query));
        if (count($query) > 0) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }
}
